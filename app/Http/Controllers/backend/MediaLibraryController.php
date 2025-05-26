<?php

namespace App\Http\Controllers\backend;

use App\MediaLibrary;
use App\Country;
use App\Format;
use App\Sector;
use App\Status;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MediaLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request = [
            'name' => $request->post('name'),
            'country_id' => $request->post('country_id'),
            'format_id' => $request->post('format_id'),
            'sector_id' => $request->post('sector_id'),
            'status_id' => $request->post('status_id')
        ];

        $data = [
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'formats' => Format::all()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'statuses' => Status::whereNotIn('id', [4])->get()->pluck('name', 'id')
        ];

        return view('backend.media.index', compact('data', 'request'));
    }

    /**
     * Process datatables ajax request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $table1 = (new MediaLibrary)->getTable();
        $table2 = (new Status)->getTable();
        $query = MediaLibrary::select("{$table1}.*")
            ->join("{$table2}", "{$table1}.status_id", '=', "{$table2}.id")
            ->with('country', 'format', 'sectors', 'status')
            ->orderBy('statuses.order', 'asc')
            ->latest();

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                $query = MediaLibrary::filter($query, $request);
            })
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', MediaLibrary::class);

        $data = [
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'formats' => Format::all()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'tags' => Tag::all()->pluck('name', 'id')
        ];

        $files = [
            'gallery' => [],
            'presentation' => [],
            'document' => [],
            'audio' => []
        ];

        return view('backend.media.create', compact('data', 'files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', MediaLibrary::class);

        $rules = [
            'name' => 'required|string|max:180',
            'date' => 'required|date_format:Y-m-d',
            'country_id' => 'required|integer|exists:countries,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'tags.*' => 'required|integer|exists:tags,id',
            'author' => 'nullable|string|max:180',
            'email' => 'nullable|string|email|max:180',
            'format_id' => 'required|integer|exists:formats,id',
            'external' => 'nullable|integer',
            'link' => 'nullable|url|max:180',
            'length' => 'nullable|max:5',
            'image' => 'nullable|string',
            'image_is_new' => 'nullable|bool',
        ];

        $data = $request->all();

        switch ($data['format_id']) {
            case Format::VIDEO:
                $rules['link'] = [
                    'required',
                    'url',
                    'max:180',
                    // 'regex:/(http(s)?:\/\/)?(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/'
                ];
                $data['external'] = 1;
                break;

            case Format::GALLERY:
                $rules['gallery'] = [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::GALLERY_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::GALLERY_MAX_FILES);
                        }
                    }
                ];
                $rules['gallery_remove'] = 'nullable';
                $data['external'] = 0;
                break;

            case Format::PRESENTATION:
                $rules['presentation'] = [
                    'required_if:external,0',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::PRESENTATION_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::PRESENTATION_MAX_FILES);
                        }
                    }
                ];
                $rules['link'] = 'nullable|url|max:180|required_if:external,1';
                break;

            case Format::DOCUMENT:
                $rules['document'] = [
                    'required_if:external,0',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::DOCUMENT_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::DOCUMENT_MAX_FILES);
                        }
                    }
                ];
                $rules['link'] = 'nullable|url|max:180|required_if:external,1';
                break;

            case Format::AUDIO:
                $rules['audio'] = [
                    'required_if:external,0',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::AUDIO_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::AUDIO_MAX_FILES);
                        }
                    }
                ];
                $rules['link'] = 'nullable|url|max:180|required_if:external,1';
                break;
        }

        $this->validate($request, $rules);

        if (empty($data['external'])) {
            $data['link'] = '';
        }

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.' . $extension;
        } else {
            unset($data['image']);
        }

        $user = auth()->user();
        if ($user->isAdmin()) {
            $data['status_id'] = Status::APPROVED;
        } else {
            $data['status_id'] = Status::PENDING;
        }

        $data['updated_by_id'] = $data['created_by_id'] = $user->id;

        $media = MediaLibrary::create($data);
        $media->sectors()->sync($data['sectors']);

        if (empty($data['tags'])) {
            $data['tags'] = [];
        }
        $media->tags()->sync($data['tags']);
        $media->save();

        if (! empty($data['image']) && ! empty($data['image_is_new'])) {
            $target = "public/medialibrary/{$media->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        $formats = Format::all();
        $format = $formats->firstWhere('id', $data['format_id']);
        if (empty($data['external']) && ! empty($format)) {
            $name = $format->media_collection;
            if (! empty($data[$name])) {
                // Insert, order and delete files
                $medias = $media->getMedia($name);

                $i = 0;
                $remove = $request->input($name . '_remove', []);
                $items = array_merge($request->input($name, []), $remove);
                foreach ($items as $item) {
                    $file = basename($item);
                    if (! empty($medias) && ! empty($m = $medias->firstWhere('file_name', $file))) {
                        if (in_array($item, $remove)) {
                            $m->delete();
                        } else {
                            $m->order_column = $i + 1;
                            $m->save();
                        }
                        ++$i;
                        continue;
                    }

                    $path = storage_path('app/public/upload/' . $file);
                    if (! file_exists($path)) {
                        continue;
                    }

                    $m = $media->addMedia($path)->toMediaCollection($name);
                    $m->order_column = $i + 1;
                    $m->save();
                    ++$i;
                }
            } else {
                $media->clearMediaCollection($name);
            }
        } else {
            foreach ($formats as $item) {
                $media->clearMediaCollection($item->media_collection);
            }
        }

        session()->flash('alert-success', __('Se ha creado la mediateca correctamente.'));
        return redirect()->route('backend.media.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MediaLibrary  $media
     * @return \Illuminate\Http\Response
     */
    public function show(MediaLibrary $media)
    {
        $this->authorize('view', $media);

        $data = [
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'formats' => Format::all()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'tags' => Tag::all()->pluck('name', 'id')
        ];

        return view('backend.media.show', compact('media', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MediaLibrary  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(MediaLibrary $media)
    {
        $this->authorize('update', $media);

        $data = [
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'formats' => Format::all()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'tags' => Tag::all()->pluck('name', 'id')
        ];

        $files = [
            'gallery' => [],
            'presentation' => [],
            'document' => [],
            'audio' => []
        ];

        $name = $media->format->media_collection;
        $files[$name] = $media->getMedia($name);

        return view('backend.media.edit', compact('media', 'data', 'files'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MediaLibrary  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MediaLibrary $media)
    {
        $this->authorize('update', $media);

        $rules = [
            'name' => 'required|string|max:180',
            'date' => 'required|date_format:Y-m-d',
            'country_id' => 'required|integer|exists:countries,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'tags.*' => 'required|integer|exists:tags,id',
            'author' => 'nullable|string|max:180',
            'email' => 'nullable|string|email|max:180',
            'format_id' => 'required|integer|exists:formats,id',
            'external' => 'nullable|integer',
            'link' => 'nullable|url|max:180',
            'length' => 'nullable|max:5',
            'image' => 'nullable|string',
            'image_is_new' => 'nullable|bool',
        ];

        $data = $request->all();

        switch ($data['format_id']) {
            case Format::VIDEO:
                $rules['link'] = [
                    'required',
                    'url',
                    'max:180',
                    // 'regex:/(http(s)?:\/\/)?(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/'
                ];
                $data['external'] = 1;
                break;

            case Format::GALLERY:
                $rules['gallery'] = [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::GALLERY_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::GALLERY_MAX_FILES);
                        }
                    }
                ];
                $rules['gallery_remove'] = 'nullable';
                $data['external'] = 0;
                break;

            case Format::PRESENTATION:
                $rules['presentation'] = [
                    'required_if:external,0',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::PRESENTATION_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::PRESENTATION_MAX_FILES);
                        }
                    }
                ];
                $rules['link'] = 'nullable|url|max:180|required_if:external,1';
                break;

            case Format::DOCUMENT:
                $rules['document'] = [
                    'required_if:external,0',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::DOCUMENT_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::DOCUMENT_MAX_FILES);
                        }
                    }
                ];
                $rules['link'] = 'nullable|url|max:180|required_if:external,1';
                break;

            case Format::AUDIO:
                $rules['audio'] = [
                    'required_if:external,0',
                    'array',
                    function ($attribute, $value, $fail) {
                        if (count($value) > MediaLibrary::AUDIO_MAX_FILES) {
                            return $fail($attribute . ' should be less than or equal to ' . MediaLibrary::AUDIO_MAX_FILES);
                        }
                    }
                ];
                $rules['link'] = 'nullable|url|max:180|required_if:external,1';
                break;
        }

        $this->validate($request, $rules);

        if (empty($data['external'])) {
            $data['link'] = '';
        }

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.' . $extension;
        } else {
            unset($data['image']);
        }

        $media->fill($data);

        $media->updated_by_id = auth()->user()->id;
        $media->sectors()->sync($data['sectors']);

        if (empty($data['tags'])) {
            $data['tags'] = [];
        }
        $media->tags()->sync($data['tags']);
        $media->save();

        if (! empty($data['image']) && ! empty($data['image_is_new'])) {
            $target = "public/medialibrary/{$media->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        $formats = Format::all();
        $format = $formats->firstWhere('id', $data['format_id']);
        if (empty($data['external']) && ! empty($format)) {
            $name = $format->media_collection;
            if (! empty($data[$name])) {
                // Insert, order and delete files
                $medias = $media->getMedia($name);

                $i = 0;
                $remove = $request->input($name . '_remove', []);
                $items = array_merge($request->input($name, []), $remove);
                foreach ($items as $item) {
                    $file = basename($item);
                    if (! empty($medias) && ! empty($m = $medias->firstWhere('file_name', $file))) {
                        if (in_array($item, $remove)) {
                            $m->delete();
                        } else {
                            $m->order_column = $i + 1;
                            $m->save();
                        }
                        ++$i;
                        continue;
                    }

                    $path = storage_path('app/public/upload/' . $file);
                    if (! file_exists($path)) {
                        continue;
                    }

                    $m = $media->addMedia($path)->toMediaCollection($name);
                    $m->order_column = $i + 1;
                    $m->save();
                    ++$i;
                }
            } else {
                $media->clearMediaCollection($name);
            }
        } else {
            foreach ($formats as $item) {
                $media->clearMediaCollection($item->media_collection);
            }
        }

        session()->flash('alert-success', __('Se ha actualizado la mediateca correctamente.'));
        return redirect()->route('backend.media.edit', $media->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MediaLibrary  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(MediaLibrary $media)
    {
        $this->authorize('delete', $media);

        if ($media->delete()) {
            return response()->json(['message' => 'ok'], 202);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    /**
     * Approve the specified resource.
     *
     * @param  \App\MediaLibrary  $media
     * @return \Illuminate\Http\Response
     */
    public function approve(MediaLibrary $media)
    {
        $this->authorize('update', $media);

        $media->status_id = Status::APPROVED;
        $media->save();

        return redirect()->route('backend.media.edit', $media->id);
    }

    /**
     * Refuse the specified resource.
     *
     * @param  \App\MediaLibrary  $media
     * @return \Illuminate\Http\Response
     */
    public function refuse(MediaLibrary $media)
    {
        $this->authorize('update', $media);

        $media->status_id = Status::REFUSED;
        $media->save();

        return redirect()->route('backend.media.edit', $media->id);
    }
}
