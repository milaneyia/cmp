<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cycle;
use Carbon\Carbon;

class CycleController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except('show', 'index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cycles = Cycle::all();
        return view('cycle.index')->with(['cycles' => $cycles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Cycle::class);
        return view('cycle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cycle::class);
        $request->validate([
            'mentorSignupsStart' => 'required|date_format:Y-m-d',
            'mentorSignupsEnd' => 'required|date_format:Y-m-d',
            'menteeSignupsStart' => 'required|date_format:Y-m-d',
            'menteeSignupsEnd' => 'required|date_format:Y-m-d',
            'cycleStart' => 'required|date_format:Y-m-d',
            'cycleEnd' => 'required|date_format:Y-m-d',
        ]);

        // insert more validation of input data

        $cycle = Cycle::create([
            'starts_at' => $request->cycleStart,
            'ends_at' => $request->cycleEnd,
            'mentor_signups_start_at' => $request->mentorSignupsStart,
            'mentor_signups_end_at' => $request->mentorSignupsEnd,
            'mentee_signups_start_at' => $request->menteeSignupsStart,
            'mentee_signups_end_at' => $request->menteeSignupsEnd,
        ]);

        if ($cycle) 
        {
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cycle = Cycle::findOrFail($id);
        // Insert some logic to select all participants on a cycle
        return view('cycle.show')->with(['cycle' => $cycle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cycle = Cycle::findOrFail($id);
        $this->authorize('update', $cycle);
        return view('cycle.edit')->with(['$cycle' => $cycle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cycle = Cycle::findOrFail($id);
        $this->authorize('update', $cycle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', $cycle);
    }
}
