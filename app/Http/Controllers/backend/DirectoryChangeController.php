<?php

namespace App\Http\Controllers\backend;

use App\DirectoryChange;
use App\Country;
use App\Entity;
use App\Sector;
use App\Http\Controllers\Controller;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DirectoryChangeController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->authorizeResource(DirectoryChangeChange::class, 'directoryChange');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.directory.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DirectoryChange  $directoryChange
     * @return \Illuminate\Http\Response
     */
    public function show(DirectoryChange $directoryChange)
    {
        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        $directory = $directoryChange->directory;

        return view('backend.directory-change.show', compact('directoryChange', 'directory', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DirectoryChange  $directoryChange
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectoryChange $directoryChange)
    {
        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        $user = $directoryChange->user;

        return view('backend.directory.edit', compact('directoryChange', 'user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DirectoryChange  $directoryChange
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Directory $directoryChange)
    {

    }

    /**
     * Approve the specified resource.
     *
     * @param  \App\DirectoryChange  $directory
     * @return \Illuminate\Http\Response
     */
    public function approve(DirectoryChange $directoryChange)
    {
        // $this->authorize('update', $directoryChange);

        $directory = $directoryChange->directory;

        DB::transaction(function () use ($directoryChange, $directory) {
            $data = $directoryChange->toArray();
            $translations = $directoryChange->getTranslationsArray();
            $data = array_merge($data, $translations);

            $directory->fill($data);
            $directory->status_id = Status::APPROVED;
            $directory->save();

            $data['sectors'] = $directoryChange->sectors->pluck('id')->toArray();
            $directory->sectors()->sync($data['sectors']);

            if ($directoryChange->image) {
                $path = "public/directory-change/{$directory->id}/{$directory->image}";
                $target = "public/directory/{$directoryChange->id}/{$directoryChange->image}";

                Storage::delete($target);
                Storage::move($path, $target);
            }

            $directoryChange->delete();
        });

        session()->flash('alert-success', __('Se han actualizado los datos correctamente.'));
        return redirect()->route('backend.directory.edit', $directory->id);
    }

    /**
     * Refuse the specified resource.
     *
     * @param  \App\DirectoryChange  $directory
     * @return \Illuminate\Http\Response
     */
    public function refuse(DirectoryChange $directoryChange)
    {
        // $this->authorize('update', $directoryChange);

        $directory = $directoryChange->directory;

        DB::transaction(function () use ($directoryChange, $directory) {
            $directoryChange->delete();

            $directory->status_id = Status::APPROVED;
            $directory->save();

            $target = "public/directory-change/{$directoryChange->id}/{$directoryChange->image}";
            Storage::delete($target);
        });

        session()->flash('alert-success', __('Rechazado los cambios correctamente.'));
        return redirect()->route('backend.directory.edit', $directory->id);
    }

}
