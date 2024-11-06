<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\StoreRequest;
use App\Http\Requests\Topic\UpdateRequest;
use App\Models\Content;
use App\Models\Semester;
use App\Models\Topic;
use App\Models\Year;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{

    public function datatables()
    {
        $topics = Topic::with('semester')->select('topics.*');
        
        return DataTables::eloquent($topics)
            ->addColumn('semester_name', function (Topic $topic) {
                return $topic->semester->name;
            })
            ->addColumn('btn', 'admin.topics.partials.btn')
            ->rawColumns(['btn'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.topics.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topic = new Topic();
        $years = Year::orderBy('name', 'asc')->get(); // Solo obtenemos los años
        return view('admin.topics.create', compact('topic', 'years'));
    }
    
    public function getSemestersByYear($yearId)
    {
        $semesters = Semester::where('year_id', $yearId)->get();
        return response()->json($semesters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        Topic::create($validatedData);

        return redirect()->route('topics.index')->with('success', 'Topic created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = Topic::findOrFail($id);
        return view('admin.topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        $years = Year::with('semesters')->orderBy('name', 'asc')->get(); // Cargar años con sus semestres
        return view('admin.topics.edit', compact('topic', 'years'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $topic = Topic::findOrFail($id);
        $topic->update($validatedData);
        return redirect()->route('topics.show', $topic->id)->with('success', 'Tema actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Topic deleted successfully!');
    }
}
