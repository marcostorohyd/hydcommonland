<?php

namespace App\Http\Controllers\backend;

use App\Event;
use App\EventAssistance;
use App\EventType;
use App\Country;
use App\Sector;
use App\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
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
            'type_id' => $request->post('type_id'),
            'country_id' => $request->post('country_id'),
            'sector_id' => $request->post('sector_id'),
            'status_id' => $request->post('status_id')
        ];

        $data = [
            'types' => EventType::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id'),
            'statuses' => Status::whereNotIn('id', [4])->get()->pluck('name', 'id')
        ];

        return view('backend.event.index', compact('data', 'request'));
    }

    /**
     * Process datatables ajax request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $table1 = (new Event)->getTable();
        $table2 = (new Status)->getTable();
        $query = Event::select("{$table1}.*")
            ->join("{$table2}", "{$table1}.status_id", '=', "{$table2}.id")
            ->with('country', 'sectors', 'status', 'type')
            ->orderBy('statuses.order', 'asc')
            ->latest();

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                $query = Event::filter($query, $request);
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
        $this->authorize('create', Event::class);

        $data = [
            'assistances' => EventAssistance::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'types' => EventType::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.event.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $rules = [
            'name' => 'required|string|max:180',
            'email' => 'required|string|email|max:180',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'nullable|date_format:Y-m-d',
            'register_url' => 'nullable|url|max:180',
            'assistance_id' => 'nullable|integer|exists:event_assistances,id',
            'type_id' => 'required|integer|exists:event_types,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'language' => 'nullable|string|max:40',
            'venue_name' => 'nullable|string|max:180',
            'venue_address' => 'nullable|string|max:180',
            'country_id' => 'required|integer|exists:countries,id',
            'image' => 'required|string',
            'image_is_new' => 'nullable|bool',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:' . implode(',', locales_except($lang, '.description')) . '|string';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.' . $extension;
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

        $event = Event::create($data);
        $event->sectors()->sync($data['sectors']);

        if (! empty($data['image_is_new'])) {
            $target = "public/event/{$event->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        session()->flash('alert-success', __('Se ha creado el evento correctamente.'));
        return redirect()->route('backend.event.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        $data = [
            'assistances' => EventAssistance::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'types' => EventType::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.event.show', compact('event', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $data = [
            'assistances' => EventAssistance::all()->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'types' => EventType::all()->pluck('name', 'id'),
            'countries' => Country::all()->sortBy('name')->pluck('name', 'id')
        ];

        return view('backend.event.edit', compact('event', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $rules = [
            'name' => 'required|string|max:180',
            'email' => 'required|string|email|max:180',
            'start' => 'required|date:Y-m-d',
            'end' => 'nullable|date:Y-m-d',
            'register_url' => 'nullable|url|max:180',
            'assistance_id' => 'nullable|integer|exists:event_assistances,id',
            'type_id' => 'required|integer|exists:event_types,id',
            'sectors.*' => 'required|integer|exists:sectors,id',
            'language' => 'nullable|string|max:40',
            'venue_name' => 'nullable|string|max:180',
            'venue_address' => 'nullable|string|max:180',
            'country_id' => 'required|integer|exists:countries,id',
            'image' => 'required|string',
            'image_is_new' => 'nullable|bool',
        ];

        foreach (locales() as $lang) {
            $rules["{$lang}.description"] = 'nullable|required_without_all:' . implode(',', locales_except($lang, '.description')) . '|string';
        }

        $this->validate($request, $rules);

        $data = $request->all();

        if (! empty($data['image_is_new'])) {
            $extension = pathinfo($data['image'], PATHINFO_EXTENSION);
            $data['image'] = 'image.' . $extension;
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

        $event->fill($data);

        $event->updated_by_id = auth()->user()->id;
        $event->sectors()->sync($data['sectors']);
        $event->save();

        if (! empty($data['image_is_new'])) {
            $target = "public/event/{$event->id}/image.{$extension}";
            Storage::delete($target);
            Storage::move('public/upload/'.basename($request->image), $target);
        }

        session()->flash('alert-success', __('Se ha actualizado el evento correctamente.'));
        return redirect()->route('backend.event.edit', $event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->delete()) {
            return response()->json(['message' => 'ok'], 202);
        }

        return response()->json(['error' => 'Internal Server Error'], 500);
    }

    /**
     * Approve the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function approve(Event $event)
    {
        $this->authorize('update', $event);

        $event->status_id = Status::APPROVED;
        $event->save();

        return redirect()->route('backend.event.edit', $event->id);
    }

    /**
     * Refuse the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function refuse(Event $event)
    {
        $this->authorize('update', $event);

        $event->status_id = status::REFUSED;
        $event->save();

        return redirect()->route('backend.event.edit', $event->id);
    }
}
