<?php

namespace App\Http\Controllers;

use App\Country;
use App\Format;
use App\MediaLibrary;
use App\Sector;
use App\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\MediaStream;

class MediaLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'countries' => Country::has('mediaLibrary')->get()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'tags' => Tag::all()->pluck('name', 'id'),
            'formats' => Format::all(),
        ];

        $group = new Collection;
        if (request()->get('close') && $filter = session('filter_media')) {
            Input::merge([
                'country_id' => $filter['country_id'],
                'sector_id' => $filter['sector_id'],
                'tag_id' => $filter['tag_id'],
                'format_id' => $filter['format_id'],
            ]);
            Input::flash();

            request()->merge([
                'country_id' => $filter['country_id'],
                'sector_id' => $filter['sector_id'],
                'tag_id' => $filter['tag_id'],
                'format_id' => $filter['format_id'],
            ]);

            foreach ($data['formats'] as $format) {
                $group = $group->merge(MediaLibrary::filter(MediaLibrary::query(), request())
                    ->where('format_id', $format->id)
                    ->with('media')
                    ->with('format')
                    ->take(9)
                    ->get());
            }
        } else {
            foreach ($data['formats'] as $format) {
                $group = $group->merge(MediaLibrary::where('format_id', $format->id)
                    ->with('media')
                    ->with('format')
                    ->take(9)
                    ->get());
            }
        }

        $group = $group->groupBy('format_id');

        return view('media.index', compact('data', 'group'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(MediaLibrary $media)
    {
        $paginate = [];
        $filter = explode(',', session('filter_media')['ids'] ?? '');
        $routeClose = 'media.index';

        try {
            $routeName = app('router')
                ->getRoutes()
                ->match(app('request')->create(URL::previous()))
                ->getName();

            if ($routeName == 'about') {
                $routeClose = 'about';
            } elseif (in_array($routeName, ['media.index', 'media.show'])) {
                for ($i = 0; $i < count($filter); $i++) {
                    if ($i) {
                        $paginate['prev'] = $filter[$i - 1];
                    }

                    if ($media->id == $filter[$i]) {
                        if (! empty($filter[$i + 1])) {
                            $paginate['next'] = $filter[$i + 1];
                        }
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            $paginate = [];
        }

        $data = [];
        if ($media->format_id == Format::VIDEO) {
            // preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $media->link, $matches);
            // preg_match("/^(http(s)?:\/\/)?(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)/", $media->link, $matches);
            preg_match("/^(http(s)?:\/\/)?(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)/", $media->link, $matches);

            $id = $media->link;
            $provider = '';
            if ($matches) {
                $id = end($matches);
                $provider = (strpos($media->link, 'vimeo') != false) ? 'vimeo' : 'youtube';
            }

            $data = [
                'id' => $id,
                'provider' => $provider,
            ];
        }

        return view('media.show', compact('media', 'paginate', 'data', 'routeClose'));
    }

    /**
     * Download the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(MediaLibrary $media)
    {
        if ($media->format_id == Format::GALLERY) {
            $downloads = $media->getMedia($media->format->media_collection);

            return MediaStream::create('commondlandnet.zip')->addMedia($downloads);
        }

        return $media->getFirstMedia($media->format->media_collection);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $this->validate($request, [
            'country_id.*' => 'nullable|integer',
            'sector_id.*' => 'nullable|integer',
            'tag_id.*' => 'nullable|integer',
            'format_id' => 'nullable|integer',
        ]);

        $query = MediaLibrary::filter(MediaLibrary::query(), $request);

        session(['filter_media' => [
            'ids' => $query->pluck('id')->implode(','),
            'country_id' => $request->post('country_id'),
            'sector_id' => $request->post('sector_id'),
            'tag_id' => $request->post('tag_id'),
            'format_id' => $request->post('format_id'),
        ]]);

        if (empty($request->input('format_id'))) {
            $group = new Collection;
            foreach (Format::all() as $format) {
                $group[] = MediaLibrary::filter(MediaLibrary::query(), request())
                    ->where('format_id', $format->id)
                    ->with('media')
                    ->with('format')
                    ->take(9)
                    ->get();
            }

            return view('media.group-list', compact('group'));
        }

        $medias = $query->paginate(6);
        $format = Format::find($request->post('format_id'));

        return view('media.list', compact('medias', 'format'));
    }
}
