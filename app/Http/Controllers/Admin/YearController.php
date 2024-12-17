<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Year\StoreRequest;
use App\Models\Year;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Yajra\DataTables\Facades\DataTables;

class YearController extends Controller
{
    public function datatables(){
        return DataTables::eloquent(Year::query())
        ->addColumn('btn', 'admin.years.partials.btn')
        ->rawColumns(['btn'])
        ->toJson();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('admin.years.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Year::create($request->validated());

        return redirect()->route('years.index')->with('success', 'Año escolar creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Year $year)
    {
        $year->load('semesters', 'students');

        foreach ($year->semesters as $semester) {
            $startDate = Carbon::parse($semester->start_date);
            $endDate = Carbon::parse($semester->end_date);
            $period = CarbonPeriod::create($startDate, $endDate);

            $businessDays = 0;
            foreach ($period as $date) {
                if ($date->isWeekday()) {
                    $businessDays++;
                }
            }
            $semester->business_days = $businessDays;
        }

        return view('admin.years.show', compact('year'));
    }
    
    public function getSemesters($yearId)
    {
        $year = Year::with('semesters')->findOrFail($yearId); // Carga los semestres relacionados
        return response()->json($year->semesters);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Year $year)
    {
        return view('admin.years.edit', compact('year'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Year $year)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $year->update($request->all());

        return redirect()->route('years.index')->with('success', 'Año escolar actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Year $year)
    {
        $year->delete();

        return redirect()->route('years.index')->with('success', 'Año escolar eliminado exitosamente.');
    }
}
