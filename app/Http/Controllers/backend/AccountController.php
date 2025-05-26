<?php

namespace App\Http\Controllers\backend;

use App\Country;
use App\DirectoryChange;
use App\Entity;
use App\Sector;
use App\Http\Controllers\Controller;
use App\Mail\AccountConfirmDeleteMail;
use App\Mail\AccountRequestDeleteMail;
use App\Notifications\DirectoryChangeRequest;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $this->authorize('view', $user);

        $directory = $user->directory;

        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        $directoryChange = $directory->change;
        if ($directoryChange) {
            $directoryChange->status_id = $directory->status_id;
            $directory = $directoryChange;
        }

        return view('backend.account.show', compact('directory', 'user', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editDirectory()
    {
        $user = Auth::user();
        $directory = $user->directory;

        $directoryChange = DirectoryChange::find($directory->id);
        if (!$directoryChange) {
            $directory->load('sectors');
            $directoryChange = DB::transaction(function () use ($directory) {
                $fillable = (new DirectoryChange)->getFillable();
                $data = array_intersect_key($directory->toArray(), array_flip($fillable));
                $translations = $directory->getTranslationsArray();
                $data['sectors'] = $directory->sectors->pluck('id')->toArray();

                $directoryChange = DirectoryChange::create($data);
                $data = array_merge($data, $translations);
                $directoryChange->fill($data);
                $directoryChange->save();
                $directoryChange->sectors()->sync($data['sectors']);

                if ($directory->image) {
                    $path = "public/directory/{$directory->id}/{$directory->image}";
                    $target = "public/directory-change/{$directoryChange->id}/{$directoryChange->image}";
                    Storage::delete($target);
                    Storage::copy($path, $target);
                }

                return $directoryChange;
            });
        }

        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.account.edit-directory', compact('directory', 'user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDirectory(Request $request)
    {
        $user = Auth::user();
        $directory = $user->directory;
        $directoryChange = $directory->change;

        if (!$directoryChange) {
            session()->flash('alert-danger', __('Ha ocurrido un error, por favor vuelva a intentarlo.'));
            return redirect()->route('backend.account.edit_directory');
        }

        $rules = [
            'name' => 'required|string|max:180',
            'email' => 'required|string|email|max:180',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:180',
            'zipcode' => 'required|string|max:20',
            'city' => 'required|string|max:80',
            'country_id' => 'required|integer|exists:countries,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'sectors' => 'required|array|exists:sectors,id',
            'entity_id' => 'required|integer|exists:entities,id',
            'contact_name' => 'nullable|string|max:180',
            'contact_email' => 'nullable|string|email|max:180',
            'contact_phone' => 'nullable|string|max:30',
            'partners' => 'nullable|integer|min:1|max:99999999999',
            'members' => 'nullable|integer|min:1|max:99999999999',
            'represented' => 'nullable|integer|min:1|max:99999999999',
            'surface' => 'nullable|integer|min:1|max:99999999999',
            'image' => 'nullable|string',
            'image_is_new' => 'nullable|bool',
            'web' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'vimeo' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|url|max:255',
            'telegram' => 'nullable|url|max:255',
            'research_gate' => 'nullable|url|max:255',
            'orcid' => 'nullable|url|max:255',
            'academia_edu' => 'nullable|url|max:255',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:' . implode(',', locales_except($lang, '.description')) . '|string';
        }

        $data = $this->validate($request, $rules);

        if (Entity::PERSON == $data['entity_id']) {
            $data['contact_name'] = null;
            $data['contact_email'] = null;
            $data['contact_phone'] = null;
        }

        $data['partners'] = in_array($data['entity_id'], [6]) ? $data['partners'] : null;
        $data['members'] = in_array($data['entity_id'], [4,5,7]) ? $data['members'] : null;
        $data['represented'] = in_array($data['entity_id'], [8]) ? $data['represented'] : null;
        $data['surface'] = in_array($data['entity_id'], [4,8]) ? $data['surface'] : null;

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'photo.' . $extension;
        } elseif (empty($data['image'])) {
            $data['image'] = null;

            if (! empty($directoryChange->image)) {
                $extension = pathinfo($directoryChange->image, PATHINFO_EXTENSION);
            }
        }

        // Locales
        foreach (locales() as $lang) {
            $directoryChange["description:{$lang}"] = $data["{$lang}"]['description'];
        }

        if (empty($directoryChange['description:en'])) {
            if (empty($directoryChange['description:es-ES'])) {
                $directoryChange['description:en'] = $directoryChange['description:fr'];
            } else {
                $directoryChange['description:en'] = $directoryChange['description:es-ES'];
            }
        }
        if (empty($directoryChange['description:es-ES'])) {
            $directoryChange['description:es-ES'] = $directoryChange['description:en'];
        }
        if (empty($directoryChange['description:fr'])) {
            $directoryChange['description:fr'] = $directoryChange['description:en'];
        }

        $directoryChange->fill($data);
        $directoryChange->save();

        $directoryChange->sectors()->sync($data['sectors']);

        if (! empty($data['image_is_new']) || empty($data['image'])) {
            if (! empty($extension)) {
                $target = "public/directory-change/{$directoryChange->id}/photo.{$extension}";
                Storage::delete($target);
            }

            if (! empty($data['image'])) {
                Storage::move('public/upload/'.basename($request->image), $target);
            }
        }

        $directory->status_id = Status::CHANGE_REQUEST;
        $directory->save();

        if ($admins = User::admin()->get()) {
            foreach ($admins as $admin) {
                try {
                    $admin->notify(new DirectoryChangeRequest($directory));
                } catch (\Throwable $th) {
                    // pass
                }
            }
        }

        session()->flash('alert-success', __('Los datos se han modificado correctamente.'));
        return redirect()->route('backend.account.show');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCommunication(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'accept_advertising' => 'nullable|boolean',
        ];

        $this->validate($request, $rules);

        $data['accept_advertising'] = $request->input('accept_advertising', null);
        $user->fill($data);

        $user->updated_by_id = $user->id;
        $user->save();

        session()->flash('alert-success', __('Se ha actualizado los datos correctamente.'));
        return redirect()->route('backend.account.show');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'password' => 'required|string|min:6|confirmed',
        ];

        $data = $this->validate($request, $rules);

        if (!empty($data['password'])) {
            $data['password'] == Hash::make($data['password']);
        }

        $user->fill($data);

        $user->updated_by_id = $user->id;
        $user->save();

        session()->flash('alert-success', __('Se ha actualizado los datos correctamente.'));
        return redirect()->route('backend.account.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->directory()->delete();
            $user->medialibraries()->delete();
            $user->events()->delete();
            $user->news()->delete();
            $user->demoCaseStudies()->delete();
            $user->delete();
        });

        if (Auth::user() === $user) {
            Auth::logout();
        }

        Mail::to($user->email)->send(new AccountConfirmDeleteMail());

        session()->flash('alert-success', __('Su cuenta ha sido borrada correctamente.'));
        return redirect()->route('home');
    }

    /**
     * Request remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestDestroy()
    {
        $user = Auth::user();

        Mail::to($user->email)->send(new AccountRequestDeleteMail($user));

        session()->flash('alert-success', 'Le hemos enviado un email de confirmación para completar la baja en esta plataforma.');
        return back();
    }
}
