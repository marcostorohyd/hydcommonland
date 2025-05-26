<?php

namespace App\Http\Controllers;

use App\News;
use App\Country;
use App\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class NewsController extends Controller
{
    /**
     * Show the house news.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'countries' => Country::has('news')->get()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id')
        ];

        if (request()->get('close') && $filter = session('filter_news')) {
            Input::merge([
                'country_id' => $filter['country_id'],
                'sector_id' => $filter['sector_id']
            ]);
            Input::flash();

            request()->merge([
                'country_id' => $filter['country_id'],
                'sector_id' => $filter['sector_id']
            ]);
            $news = News::filter(News::query(), request())
                        ->paginate(6);
        } else {
            $news = News::paginate(6);
        }

        return view('news.index', compact('data', 'news'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Illuminate\Http\Request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, News $news)
    {
        $paginate = [];
        $filter = explode(',', session('filter_news')['ids'] ?? '');

        try {
            if (in_array(app('router')->getRoutes()->match(
                app('request')->create(URL::previous())
            )->getName(), ['news.index', 'news.show'])) {
                for ($i=0; $i < count($filter); $i++) {
                    if ($i) {
                        $paginate['prev'] = $filter[$i-1];
                    }

                    if ($news->id == $filter[$i]) {
                        if (! empty($filter[$i+1])) {
                            $paginate['next'] = $filter[$i+1];
                        }
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            $paginate = [];
        }

        return view('news.show', compact('news', 'paginate'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $this->validate($request, [
            'country_id.*' => 'nullable|integer',
            'sector_id.*' => 'nullable|integer'
        ]);

        $query = News::filter(News::query(), $request);

        session(['filter_news' => [
            'ids' => $query->pluck('id')->implode(','),
            'country_id' => $request->post('country_id'),
            'sector_id' => $request->post('sector_id')
        ]]);

        $news = $query->paginate(6);

        $filter = $request->only('country_id', 'sector_id');

        return view('news.list', compact('news', 'filter'));
    }
}
