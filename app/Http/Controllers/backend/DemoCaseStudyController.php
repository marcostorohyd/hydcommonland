<?php

namespace App\Http\Controllers\backend;

use App\Condition;
use App\Country;
use App\DemoCaseStudy;
use App\Http\Controllers\Controller;
use App\Notifications\DemoCaseStudyStoreNotification;
use App\Sector;
use App\Status;
use App\User;
use App\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DemoCaseStudyController extends Controller
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
            'status_id' => $request->post('status_id'),
        ];

        $data = [
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'statuses' => Status::whereNotIn('id', [4])->get()->pluck('name', 'id'),
        ];

        return view('backend.demo.index', compact('data', 'request'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {

        $table1 = (new DemoCaseStudy)->getTable();
        $table2 = (new Status)->getTable();
        $query = DemoCaseStudy::select("{$table1}.*")
            ->join("{$table2}", "{$table1}.status_id", '=', "{$table2}.id")
            ->with('country', 'sectors', 'status')
            ->orderBy('statuses.order', 'asc')
            ->latest();

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                $query = DemoCaseStudy::filter($query, $request);
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
        $this->authorize('create', DemoCaseStudy::class);

        $data = [
            'conditions' => Condition::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'values' => Value::all()->pluck('name', 'id'),
        ];

        return view('backend.demo.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', DemoCaseStudy::class);

        $rules = [
            'name' => 'required|string|max:180',
            'date' => 'required|date_format:Y-m-d',
            'country_id' => 'required|integer|exists:countries,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'values.*' => 'required|integer|exists:values,id',
            'condition_id' => 'required|integer|exists:conditions,id',
            'email' => 'nullable|string|email|max:180',
            'link' => 'nullable|url|max:180',
            'link2' => 'nullable|url|max:180',
            'link3' => 'nullable|url|max:180',
            'link4' => 'nullable|url|max:180',
            'link5' => 'nullable|url|max:180',
            'image' => 'required|string',
            'image_is_new' => 'nullable|bool',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:'.implode(',', locales_except($lang, '.description')).'|string';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.'.$extension;
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

        $demo = DemoCaseStudy::create($data);
        $demo->sectors()->sync($data['sectors']);
        $demo->values()->sync($data['values']);

        if (! empty($data['image_is_new'])) {
            $target = "public/demo/{$demo->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        if (! $user->isAdmin() && $admins = User::admin()->get()) {
            foreach ($admins as $admin) {
                try {
                    $admin->notify(new DemoCaseStudyStoreNotification($demo));
                } catch (\Throwable $th) {
                    // pass
                }
            }
        }

        session()->flash('alert-success', __('Se ha creado el caso demostrativo correctamente.'));

        return redirect()->route('backend.demo.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(DemoCaseStudy $demo)
    {
        $this->authorize('view', $demo);

        $data = [
            'conditions' => Condition::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'values' => Value::all()->pluck('name', 'id'),
        ];

        return view('backend.demo.show', compact('demo', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(DemoCaseStudy $demo)
    {
        $this->authorize('update', $demo);

        $data = [
            'conditions' => Condition::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'values' => Value::all()->pluck('name', 'id'),
        ];

        return view('backend.demo.edit', compact('demo', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemoCaseStudy $demo)
    {
        $this->authorize('update', $demo);

        $rules = [
            'name' => 'required|string|max:180',
            'date' => 'required|date_format:Y-m-d',
            'country_id' => 'required|integer|exists:countries,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'values.*' => 'required|integer|exists:values,id',
            'condition_id' => 'required|integer|exists:conditions,id',
            'email' => 'nullable|string|email|max:180',
            'link' => 'nullable|url|max:180',
            'link2' => 'nullable|url|max:180',
            'link3' => 'nullable|url|max:180',
            'link4' => 'nullable|url|max:180',
            'link5' => 'nullable|url|max:180',
            'image' => 'required|string',
            'image_is_new' => 'nullable|bool',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:'.implode(',', locales_except($lang, '.description')).'|string';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.'.$extension;
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

        $demo->fill($data);

        $demo->updated_by_id = auth()->user()->id;
        $demo->sectors()->sync($data['sectors']);
        $demo->values()->sync($data['values']);
        $demo->save();

        if (! empty($data['image_is_new'])) {
            $target = "public/demo/{$demo->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        session()->flash('alert-success', __('Se ha actualizado el caso demostrativo correctamente.'));

        return redirect()->route('backend.demo.edit', $demo->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemoCaseStudy $demo)
    {
        $this->authorize('delete', $demo);

        if ($demo->delete()) {
            return response()->json(['message' => 'ok'], 202);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    /**
     * Approve the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve(DemoCaseStudy $demo)
    {
        $this->authorize('update', $demo);

        $demo->status_id = Status::APPROVED;
        $demo->save();

        return redirect()->route('backend.demo.edit', $demo->id);
    }

    /**
     * Refuse the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function refuse(DemoCaseStudy $demo)
    {
        $this->authorize('update', $demo);

        $demo->status_id = Status::REFUSED;
        $demo->save();

        return redirect()->route('backend.demo.edit', $demo->id);
    }
}
