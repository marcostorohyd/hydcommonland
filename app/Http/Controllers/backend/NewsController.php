<?php

namespace App\Http\Controllers\backend;

use App\News;
use App\Country;
use App\Sector;
use App\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
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
            'sector_id' => $request->post('sector_id'),
            'status_id' => $request->post('status_id')
        ];

        $data = [
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'statuses' => Status::whereNotIn('id', [4])->get()->pluck('name', 'id')
        ];

        return view('backend.news.index', compact('data', 'request'));
    }

    /**
     * Process datatables ajax request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $table1 = (new News)->getTable();
        $table2 = (new Status)->getTable();
        $query = News::select("{$table1}.*")
            ->join("{$table2}", "{$table1}.status_id", '=', "{$table2}.id")
            ->with('country', 'sectors', 'status')
            ->orderBy('statuses.order', 'asc')
            ->latest();

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                $query = News::filter($query, $request);
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
        $this->authorize('create', News::class);

        $data = [
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.news.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', News::class);

        $rules = [
            'name' => 'required|string|max:180',
            'date' => 'required|date_format:Y-m-d',
            'country_id' => 'required|integer|exists:countries,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'email' => 'string|email|max:180',
            'link' => 'nullable|url|max:180',
            'image' => 'required|string',
            'image_is_new' => 'nullable|bool',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:' . implode(',', locales_except($lang, '.description')) . '|string';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.' . $extension;
        } else {
            unset($data['image']);
        }

        // Locales
        foreach (locales() as $lang) {
            $data["description:{$lang}"] = $data["{$lang}"]['description'];
        }

        if (empty($data['description:en'])) {
            if (empty($data['description:es-ES'])) {
                $data['description:en'] = $data['description:fr'];
            } else {
                $data['description:en'] = $data['description:es-ES'];
            }
        }
        if (empty($data['description:es-ES'])) {
            $data['description:es-ES'] = $data['description:en'];
        }
        if (empty($data['description:fr'])) {
            $data['description:fr'] = $data['description:en'];
        }

        $user = auth()->user();
        if ($user->isAdmin()) {
            $data['status_id'] = Status::APPROVED;
        } else {
            $data['status_id'] = Status::PENDING;
        }

        $data['updated_by_id'] = $data['created_by_id'] = $user->id;

        $news = News::create($data);
        $news->sectors()->sync($data['sectors']);

        if (! empty($data['image_is_new'])) {
            $target = "public/news/{$news->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        session()->flash('alert-success', __('Se ha creado la noticia correctamente.'));
        return redirect()->route('backend.news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        $this->authorize('view', $news);

        $data = [
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.news.show', compact('news', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $this->authorize('update', $news);

        $data = [
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.news.edit', compact('news', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $this->authorize('update', $news);

        $rules = [
            'name' => 'required|string|max:180',
            'date' => 'required|date_format:Y-m-d',
            'country_id' => 'required|integer|exists:countries,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'email' => 'string|email|max:180',
            'link' => 'nullable|url|max:180',
            'image' => 'required|string',
            'image_is_new' => 'nullable|bool',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:' . implode(',', locales_except($lang, '.description')) . '|string';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.' . $extension;
        } else {
            unset($data['image']);
        }

        // Locales
        foreach (locales() as $lang) {
            $data["description:{$lang}"] = $data["{$lang}"]['description'];
        }

        if (empty($data['description:en'])) {
            if (empty($data['description:es-ES'])) {
                $data['description:en'] = $data['description:fr'];
            } else {
                $data['description:en'] = $data['description:es-ES'];
            }
        }
        if (empty($data['description:es-ES'])) {
            $data['description:es-ES'] = $data['description:en'];
        }
        if (empty($data['description:fr'])) {
            $data['description:fr'] = $data['description:en'];
        }

        $news->fill($data);

        $news->updated_by_id = auth()->user()->id;
        $news->sectors()->sync($data['sectors']);
        $news->save();

        if (! empty($data['image_is_new'])) {
            $target = "public/news/{$news->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        session()->flash('alert-success', __('Se ha actualizado la noticia correctamente.'));
        return redirect()->route('backend.news.edit', $news->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $this->authorize('delete', $news);

        if ($news->delete()) {
            return response()->json(['message' => 'ok'], 202);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    /**
     * Approve the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function approve(News $news)
    {
        $this->authorize('update', $news);

        $news->status_id = Status::APPROVED;
        $news->save();

        return redirect()->route('backend.news.edit', $news->id);
    }

    /**
     * Refuse the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function refuse(News $news)
    {
        $this->authorize('update', $news);

        $news->status_id = Status::REFUSED;
        $news->save();

        return redirect()->route('backend.news.edit', $news->id);
    }
}
