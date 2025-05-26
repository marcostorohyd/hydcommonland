<?php

namespace App\Http\Controllers\backend;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Directory;

class CountryController extends Controller
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
            'contact_id' => $request->post('contact_id')
        ];

        $data = [
            'directories' => []
        ];

        return view('backend.country.index', compact('data', 'request'));
    }

    /**
     * Process datatables ajax request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $directories = Country::with('contact');

        return DataTables::of($directories)
            ->filter(function ($query) use ($request) {
                if (! empty($search = $request->get('name'))) {
                    $query->whereTranslationLike('name', "%{$search}%");
                }
                if (! empty($search = $request->get('contact_id'))) {
                    $query->where('contact_id', $search);
                }
            })
            ->setRowId('row-'.'{{ $id }}')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ['directories' => []];
        if ($contact_id = old('contact_id')) {
            $directory = Directory::findOrFail($contact_id);
            $data['directories'] = [$directory->get()->pluck('name_with_status', 'id')];
        }

        return view('backend.country.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'contact_id' => 'nullable|integer|exists:directories,id',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.name"] = ['required', 'string'];
        }

        $this->validate($request, $rules);
        $data = $request->all();

        $data['id_usuario_alta'] = $data['id_usuario_act'] = auth()->user()->id;
        Country::create($data);

        session()->flash('alert-success', 'Se ha creado el país correctamente.');
        return redirect()->route('backend.country.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        $data = ['directories' => []];
        if ($contact_id = old('contact_id', $country->contact_id)) {
            $directory = Directory::find($contact_id);
            if ($directory) {
                $data['directories'] = [$directory->get()->pluck('name_with_status', 'id')];
            }
        }

        return view('backend.country.edit', compact('country', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $rules = [
            'contact_id' => 'nullable|integer|exists:directories,id',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.name"] = ['required', 'string'];
        }

        $this->validate($request, $rules);

        $country->fill($request->all());
        $country->updated_by_id = auth()->user()->id;
        $country->save();

        session()->flash('alert-success', 'Se ha actualizado el país correctamente.');
        return redirect()->route('backend.country.edit', $country->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Country $country)
    {
        if ($country->directories->count()) {
            return response()->json(['error' => 'Solo se pueden eliminar países sin directorios asociados.'], 422);
        }

        if ($country->delete()) {
            return response()->json(['message' => 'ok'], 202);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function unassignContact(Country $country)
    {
        $country->contact_id = null;
        if ($country->save()) {
            return response()->json(['message' => 'ok'], 202);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
