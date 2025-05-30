<?php

namespace App\Http\Controllers;

use App\Condition;
use App\Country;
use App\DemoCaseStudy;
use App\Sector;
use App\Value;
use Illuminate\Http\Request;

class DemoCaseStudyController extends Controller
{
    /**
     * Show the house demo case study.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Value::all();
        $filter = [];

        $data = [
            'conditions' => Condition::all()->pluck('name', 'id'),
            'countries' => Country::has('demos')->get()->sortBy('name')->pluck('name', 'id'),
            'sectors' => Sector::all()->pluck('name', 'id'),
            'values' => $values->pluck('name', 'id'),
        ];

        if (request()->get('close') && $filter = session('filter_demo')) {
            request()->merge([
                'condition_id' => $filter['condition_id'],
                'country_id' => $filter['country_id'],
                'sector_id' => $filter['sector_id'],
                'value_id' => $filter['value_id'],
            ]);
            $demos = DemoCaseStudy::filter(DemoCaseStudy::query(), request())
                ->paginate(8);
        } else {
            session()->forget('filter_demo');
            $demos = DemoCaseStudy::paginate(8);
        }

        return view('demo.index', compact('data', 'demos', 'values', 'filter'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DemoCaseStudy $demo)
    {
        $paginate = [];
        $current = $request->input('current', 1);

        try {
            if ($filter = session('filter_demo')) {
                request()->merge([
                    'condition_id' => $filter['condition_id'],
                    'country_id' => $filter['country_id'],
                    'sector_id' => $filter['sector_id'],
                    'value_id' => $filter['value_id'],
                ]);
            }

            $demos = DemoCaseStudy::filter(DemoCaseStudy::query(), request())
                ->where('id', '!=', $demo->id)
                ->offset($current < 3 ? 0 : $current - 2)
                ->limit($current == 1 ? 1 : 2)
                ->get();

            if ($current == 1) {
                $paginate['next'] = optional($demos->first())->id;
            } elseif ($demos->count() == 1) { // Last page
                $paginate['prev'] = optional($demos->first())->id;
            } else {
                $paginate['prev'] = optional($demos->first())->id;
                $paginate['next'] = optional($demos->last())->id;
            }
        } catch (\Exception $e) {
            $paginate = [];
        }

        return view('demo.show', compact('demo', 'paginate', 'current'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $this->validate($request, [
            'condition_id.*' => 'nullable|integer',
            'country_id.*' => 'nullable|integer',
            'sector_id.*' => 'nullable|integer',
            'value_id.*' => 'nullable|integer',
        ]);

        $query = DemoCaseStudy::filter(DemoCaseStudy::query(), $request);

        session(['filter_demo' => [
            'condition_id' => $request->input('condition_id'),
            'country_id' => $request->input('country_id'),
            'sector_id' => $request->input('sector_id'),
            'value_id' => $request->input('value_id'),
        ]]);

        $demos = $query->paginate(8);

        $filter = $request->only('condition_id', 'country_id', 'sector_id', 'value_id');

        return view('demo.list', compact('demos', 'filter'));
    }
}
