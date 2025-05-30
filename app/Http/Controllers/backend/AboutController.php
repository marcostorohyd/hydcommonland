<?php

namespace App\Http\Controllers\backend;

use App\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $about = Config::where('name', 'like', 'about_%')
            ->pluck('value', 'name')
            ->all();

        return view('backend.about.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'about_leaflet_image' => 'nullable|string|max:190',
            'about_leaflet_image_is_new' => 'nullable|bool',
        ];

        foreach (locales() as $lang) {
            $rules["about.{$lang}"] = 'nullable|required_without_all:'.implode(',', locales_except($lang, '.about')).'|string';
            $rules["{$lang}.about_leaflet_link"] = 'nullable|url|max:180';
        }

        $this->validate($request, $rules);
        $data = $request->all();

        $about = Config::where('name', 'like', 'about_%')->pluck('value', 'name')->all();

        if (! empty($data['about_leaflet_image_is_new'])) {
            $extension = pathinfo($data['about_leaflet_image'], PATHINFO_EXTENSION);
            $data['about_leaflet_image'] = 'about-leaflet.'.$extension;
        } elseif (empty($data['about_leaflet_image'])) {
            $data['about_leaflet_image'] = '';

            if (! empty($about['about_leaflet_image'])) {
                $extension = pathinfo($about['about_leaflet_image'], PATHINFO_EXTENSION);
            }
        }

        $about = [];
        foreach (locales() as $lang) {
            $about["about_$lang"] = $data['about']["{$lang}"];
            $about["about_leaflet_link_$lang"] = $data["{$lang}"]['about_leaflet_link'];
        }
        $about['about_leaflet_image'] = $data['about_leaflet_image'];

        if (empty($about['about_en'])) {
            if (empty($about['about_es-ES'])) {
                $about['about_en'] = $about['about_fr'];
            } else {
                $about['about_en'] = $about['about_es-ES'];
            }
        }
        if (empty($about['about_es-ES'])) {
            $about['about_es-ES'] = $about['about_en'];
        }
        if (empty($about['about_fr'])) {
            $about['about_fr'] = $about['about_en'];
        }

        $user_id = auth()->user()->id;
        foreach ($about as $name => $value) {
            Config::updateOrCreate(
                ['name' => $name],
                ['value' => $value, 'updated_by_id' => $user_id]
            );
        }

        if (! empty($data['about_leaflet_image_is_new']) || empty($data['about_leaflet_image'])) {
            if (! empty($extension)) {
                $target = "public/config/about-leaflet.{$extension}";
                Storage::delete($target);
            }

            if (! empty($data['about_leaflet_image'])) {
                Storage::move('public/upload/'.basename($request->about_leaflet_image), $target);
            }
        }

        session()->flash('alert-success', 'Se ha actualizado la configuración correctamente.');

        return redirect()->route('backend.about.edit');
    }
}
