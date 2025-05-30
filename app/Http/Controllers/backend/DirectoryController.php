<?php

namespace App\Http\Controllers\backend;

use App\Country;
use App\Directory;
use App\Entity;
use App\Http\Controllers\Controller;
use App\Sector;
use App\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class DirectoryController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Directory::class, 'directory');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Directory::class);

        $request = [
            'name' => $request->post('name'),
            'entity_id' => $request->post('entity_id'),
            'country_id' => $request->post('country_id'),
            'sector_id' => $request->post('sector_id'),
            'status_id' => $request->post('status_id'),
        ];

        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'statuses' => Status::all()->pluck('name', 'id'),
        ];

        return view('backend.directory.index', compact('data', 'request'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $this->authorize('viewAny', Directory::class);

        $table1 = (new Directory)->getTable();
        $table2 = (new Status)->getTable();
        $directories = Directory::select("{$table1}.*")
            ->with('entity', 'country', 'sectors', 'status')
            ->join("{$table2}", "{$table1}.status_id", '=', "{$table2}.id")
            ->orderBy('statuses.order', 'asc')
            ->latest();

        return DataTables::of($directories)
            ->filter(function ($query) use ($request) {
                if (! empty($search = $request->get('name'))) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }
                if (! empty($search = $request->get('entity_id'))) {
                    $query->where('entity_id', $search);
                }
                if (! empty($search = $request->get('country_id'))) {
                    $query->where('country_id', $search);
                }
                if (! empty($search = $request->get('sectors'))) {
                    $query->whereHas('sectors', function ($query) use ($search) {
                        $query->where('directory_sector.sector_id', $search);
                    });
                }
                if (! is_null($search = $request->get('status_id'))) {
                    $query->where('status_id', $search);
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
        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
        ];

        return view('backend.directory.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            // login
            'password' => 'nullable|string|min:6|confirmed',
            // directory
            'name' => 'required|string|max:180',
            'email' => 'required|string|email|max:180|unique:users,email,NULL,NULL,deleted_at,NULL',
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
            'linkedin' => 'nullable|url|max:255',
            'research_gate' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'vimeo' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|url|max:255',
            'telegram' => 'nullable|url|max:255',
            'orcid' => 'nullable|url|max:255',
            'academia_edu' => 'nullable|url|max:255',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:'.implode(',', locales_except($lang, '.description')).'|string';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        if ($data['entity_id'] == Entity::PERSON) {
            $data['contact_name'] = null;
            $data['contact_email'] = null;
            $data['contact_phone'] = null;
        }

        $data['partners'] = in_array($data['entity_id'], [6]) ? $data['partners'] : null;
        $data['members'] = in_array($data['entity_id'], [4, 5, 7]) ? $data['members'] : null;
        $data['represented'] = in_array($data['entity_id'], [8]) ? $data['represented'] : null;
        $data['surface'] = in_array($data['entity_id'], [4, 8]) ? $data['surface'] : null;

        $current_user_id = auth()->user()->id;

        // user
        $user = User::create([
            'email' => $data['user_email'],
            'password' => bcrypt($data['password']),
            'approved_at' => Carbon::now(),
            'id_usuario_alta' => $current_user_id,
            'id_usuario_act' => $current_user_id,
        ]);

        if (! empty($data['image'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'photo.'.$extension;
        }

        // Locales
        foreach (locales() as $lang) {
            $directory["description:{$lang}"] = $data["{$lang}"]['description'];
        }

        if (empty($directory['description:en'])) {
            if (empty($directory['description:es-ES'])) {
                $directory['description:en'] = $directory['description:fr'];
            } else {
                $directory['description:en'] = $directory['description:es-ES'];
            }
        }
        if (empty($directory['description:es-ES'])) {
            $directory['description:es-ES'] = $directory['description:en'];
        }
        if (empty($directory['description:fr'])) {
            $directory['description:fr'] = $directory['description:en'];
        }

        $data['user_id'] = $user->id;
        $data['status_id'] = Status::APPROVED;
        $data['updated_by_id'] = $data['created_by_id'] = $current_user_id;

        $directory = Directory::create($data);
        $directory->sectors()->sync($data['sectors']);

        if (! empty($data['image'])) {
            Storage::move('public/upload/'.basename($request->image), "public/directory/{$directory->id}/photo.{$extension}");
        }

        session()->flash('alert-success', __('Se ha creado el usuario correctamente.'));

        return redirect()->route('backend.directory.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Directory $directory)
    {
        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
        ];

        $user = $directory->user;

        return view('backend.directory.show', compact('directory', 'user', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Directory $directory)
    {
        $data = [
            'entities' => Entity::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
        ];

        $user = $directory->user;

        return view('backend.directory.edit', compact('directory', 'user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Directory $directory)
    {
        $rules = [
            // login
            'password' => 'nullable|string|min:6|confirmed',
            // directory
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
            $rules["{$lang}.description"] = 'nullable|required_without_all:'.implode(',', locales_except($lang, '.description')).'|string';
        }

        $this->validate($request, $rules);

        if ($request->post('password')) {
            $data = $request->all();
            $directory->user->password = bcrypt($data['password']);
            $directory->user->save();
        } else {
            $data = $request->except('password');
        }

        if ($data['entity_id'] == Entity::PERSON) {
            $data['contact_name'] = null;
            $data['contact_email'] = null;
            $data['contact_phone'] = null;
        }

        $data['partners'] = in_array($data['entity_id'], [6]) ? $data['partners'] : null;
        $data['members'] = in_array($data['entity_id'], [4, 5, 7]) ? $data['members'] : null;
        $data['represented'] = in_array($data['entity_id'], [8]) ? $data['represented'] : null;
        $data['surface'] = in_array($data['entity_id'], [4, 8]) ? $data['surface'] : null;

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'photo.'.$extension;
        } elseif (empty($data['image'])) {
            $data['image'] = null;

            if (! empty($directory->image)) {
                $extension = pathinfo($directory->image, PATHINFO_EXTENSION);
            }
        }

        // Locales
        foreach (locales() as $lang) {
            $directory["description:{$lang}"] = $data["{$lang}"]['description'];
        }

        if (empty($directory['description:en'])) {
            if (empty($directory['description:es-ES'])) {
                $directory['description:en'] = $directory['description:fr'];
            } else {
                $directory['description:en'] = $directory['description:es-ES'];
            }
        }
        if (empty($directory['description:es-ES'])) {
            $directory['description:es-ES'] = $directory['description:en'];
        }
        if (empty($directory['description:fr'])) {
            $directory['description:fr'] = $directory['description:en'];
        }

        $directory->fill($data);

        $directory->updated_by_id = auth()->user()->id;
        $directory->sectors()->sync($data['sectors']);
        $directory->save();

        if (! empty($data['image_is_new']) || empty($data['image'])) {
            if (! empty($extension)) {
                $target = "public/directory/{$directory->id}/photo.{$extension}";
                Storage::delete($target);
            }

            if (! empty($data['image'])) {
                Storage::move('public/upload/'.basename($request->image), $target);
            }
        }

        session()->flash('alert-success', __('Se ha actualizado el usuario correctamente.'));

        return redirect()->route('backend.directory.edit', $directory->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directory $directory)
    {
        $flag = DB::transaction(function () use ($directory) {
            $directory->delete();
            $directory->user->medialibraries()->delete();
            $directory->user->events()->delete();
            $directory->user->news()->delete();
            $directory->user->demoCaseStudies()->delete();
            $directory->user->delete();

            return true;
        });

        if ($flag) {
            if (request()->ajax()) {
                return response()->json(['message' => 'ok'], 202);
            }

            session()->flash('alert-success', __('Se ha eliminado el usuario correctamente.'));

            return redirect()->route('backend.directory.index');
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    /**
     * Approve the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve(Directory $directory)
    {
        $this->authorize('update', $directory);

        DB::transaction(function () use ($directory) {
            $directory->status_id = Status::APPROVED;
            $directory->save();

            $directory->user->approved_at = now();
            $directory->user->save();
        });

        return redirect()->route('backend.directory.edit', $directory->id);
    }

    /**
     * Refuse the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function refuse(Directory $directory)
    {
        $this->authorize('update', $directory);

        DB::transaction(function () use ($directory) {
            $directory->status_id = Status::REFUSED;
            $directory->save();

            $directory->user->approved_at = null;
            $directory->user->save();
        });

        return redirect()->route('backend.directory.edit', $directory->id);
    }

    /**
     * Search directory.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Directory::class);

        if (! $request->ajax()) {
            return $this->index($request);
        }

        if (! $search = $request->get('search')) {
            return response()->json('Bad Request', 400);
        }

        return response()->json(
            Directory::select([
                'id',
                'name',
                'status_id',
            ])
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->take(20)
                ->get()
        );
    }
}
