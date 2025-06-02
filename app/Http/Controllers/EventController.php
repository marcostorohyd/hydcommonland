<?php

namespace App\Http\Controllers;

use App\Country;
use App\Event;
use App\EventType;
use App\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'countries' => Country::has('events')->get()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'types' => EventType::all()->pluck('name', 'id'),
        ];

        if (request()->get('close') && $filter = session('filter_event')) {
            Input::merge([
                'country_id' => $filter['country_id'],
                'sector_id' => $filter['sector_id'],
                'type_id' => $filter['type_id'],
            ]);
            Input::flash();
        }

        $events = Event::all();

        return view('event.index', compact('data', 'events'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $query = Event::with('sectors')
            ->with('type')
            ->with('country')
            ->with('status')
            ->latest();

        session(['filter_event' => [
            'ids' => $query->pluck('id')->implode(','),
            'country_id' => $request->post('country_id'),
            'sector_id' => $request->post('sector_id'),
            'type_id' => $request->post('type_id'),
        ]]);

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                $query = Event::filter($query, $request);
            })
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Event $event)
    {
        $paginate = [];
        $filter = explode(',', session('filter_event')['ids'] ?? '');

        try {
            if (in_array(app('router')->getRoutes()->match(
                app('request')->create(URL::previous())
            )->getName(), ['event.index', 'event.show'])) {
                for ($i = 0; $i < count($filter); $i++) {
                    if ($i) {
                        $paginate['prev'] = $filter[$i - 1];
                    }

                    if ($event->id == $filter[$i]) {
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

        return view('event.show', compact('event', 'paginate'));
    }
}
