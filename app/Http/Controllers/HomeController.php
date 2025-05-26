<?php

namespace App\Http\Controllers;

use App\Entity;
use App\Config;
use App\Country;
use App\Sector;
use App\Directory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Show the home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'countries' => Country::has('directories')->get()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id')
        ];

        if (request()->get('close') && $filter = session('filter_directory')) {
            Input::merge([
                'entity_id' => $filter['entity_id'],
                'country_id' => $filter['country_id'],
                'sector_id' => $filter['sector_id']
            ]);
            Input::flash();
        }

        $directories = Directory::whereNotNull('latitude')
                                ->whereNotNull('longitude')
                                ->orderBy('name')
                                ->with('entity')
                                ->get();

        $tmp = [];
        foreach ($directories as $directory) {
            if (array_key_exists("{$directory->latitude},{$directory->longitude}", $tmp)) {
                $tmp["{$directory->latitude},{$directory->longitude}"]['data'][] = [
                    'id' => $directory->id,
                    'name' => $directory->name,
                    'entity' => [
                        'id' => $directory->entity->id,
                        'name' => $directory->entity->name
                    ]
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
                                'name' => $directory->entity->name
                            ]
                        ]
                    ]
                ];
            }
        }
        $locations = new Collection($tmp);

        return view('home', compact('data', 'locations'));
    }

    /**
     * Show the about.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        $about = Config::getByLocale('about');
        $leaflet_link = Config::getByLocale('about_leaflet_link');
        $leaflet_image = Config::where('name', 'about_leaflet_image')->value('value');

        return view('about', compact('about', 'leaflet_link', 'leaflet_image'));
    }

    /**
     * Show the contact.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        $config = Config::pluck('value', 'name')->all();
        $countries = Country::select('countries.id', 'countries.contact_id', 't.name')
                            ->has('contact')
                            ->join('country_translations as t', function ($join) {
                                $join->on('countries.id', '=', 't.country_id')
                                    ->where('t.locale', '=', locale());
                            })
                            ->groupBy('countries.id', 'countries.contact_id', 't.name')
                            ->orderBy('t.name', 'asc')
                            ->get();

        return view('contact', compact('config', 'countries'));
    }
}
