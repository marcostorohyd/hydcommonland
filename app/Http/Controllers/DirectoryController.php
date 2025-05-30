<?php

namespace App\Http\Controllers;

use App\Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'entity_id.*' => 'nullable|integer',
            'country_id.*' => 'nullable|integer',
            'sector_id.*' => 'nullable|integer',
        ]);

        $query = Directory::filter(Directory::query(), $request)
            ->orderBy('name');

        // session(['filter_directory' => $request->only('entity_id', 'country_id', 'sector_id')]);
        // session(['filter_directory' => $query->pluck('id')->implode(',')]);
        session(['filter_directory' => [
            'ids' => $query->pluck('id')->implode(','),
            'entity_id' => $request->post('entity_id'),
            'country_id' => $request->post('country_id'),
            'sector_id' => $request->post('sector_id'),
        ]]);

        $directories = $query->paginate(24);

        $group = $directories->groupBy(function ($item) {
            return $item->name[0];
        });

        $filter = $request->only('entity_id', 'country_id', 'sector_id');

        return view('directory.index', compact('directories', 'group', 'filter'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Directory $directory)
    {
        // $filter = Directory::filter(Directory::query(), $request)
        //                         ->orderBy('name')
        //                         ->pluck('id');

        $paginate = [];
        $filter = explode(',', session('filter_directory')['ids'] ?? '');
        try {
            if (in_array(app('router')->getRoutes()->match(
                app('request')->create(URL::previous())
            )->getName(), ['home', 'directory.show'])) {
                for ($i = 0; $i < count($filter); $i++) {
                    if ($i) {
                        $paginate['prev'] = $filter[$i - 1];
                    }

                    if ($directory->id == $filter[$i]) {
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

        return view('directory.show', compact('directory', 'paginate'));
    }

    /**
     * Display a map.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function map(Request $request)
    {
        $this->validate($request, [
            'entity_id.*' => 'nullable|integer',
            'country_id.*' => 'nullable|integer',
            'sector_id.*' => 'nullable|integer',
        ]);

        $directories = Directory::filter(Directory::query(), $request)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('name')
            ->with('entity')
            ->get();

        session(['filter_directory' => [
            'ids' => $directories->pluck('id')->implode(','),
            'entity_id' => $request->post('entity_id'),
            'country_id' => $request->post('country_id'),
            'sector_id' => $request->post('sector_id'),
        ]]);

        $tmp = [];
        foreach ($directories as $directory) {
            if (array_key_exists("{$directory->latitude},{$directory->longitude}", $tmp)) {
                $tmp["{$directory->latitude},{$directory->longitude}"]['data'][] = [
                    'id' => $directory->id,
                    'name' => $directory->name,
                    'entity' => [
                        'id' => $directory->entity->id,
                        'name' => $directory->entity->name,
                    ],
                ];
            } else {
                $tmp["{$directory->latitude},{$directory->longitude}"] = [
                    'latitude' => $directory->latitude,
                    'longitude' => $directory->longitude,
                    'data' => [
                        [
                            'id' => $directory->id,
                            'name' => $directory->name,
                            'entity' => [
                                'id' => $directory->entity->id,
                                'name' => $directory->entity->name,
                            ],
                        ],
                    ],
                ];
            }
        }
        $locations = new Collection($tmp);

        $flag = true;

        return view('directory.map', compact('locations', 'flag'));
    }
}
