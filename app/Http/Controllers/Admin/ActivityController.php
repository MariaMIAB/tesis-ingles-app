<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Topic;
use App\Traits\Trashable;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ActivityController extends Controller
{
    use Trashable;
    
    public function datatables()
    {
        $query = Activity::with('topic');

        return DataTables::eloquent($query)
            ->addColumn('topic_name', function (Activity $activity) {
                return $activity->topic->name;
            })
            ->addColumn('btn', 'admin.activities.partials.btn')
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function index()
    {
        $activities = Activity::with('topic')->get();
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        $topics = Topic::all();
        return view('admin.activities.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'topic_id' => 'required|exists:topics,id',
            'scorm_file' => 'nullable|mimes:zip',
            'link' => 'nullable|url',
        ]);

        $scormPath = null;
        if ($request->hasFile('scorm_file')) {
            $file = $request->file('scorm_file');
            $folderName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $destinationPath = public_path("scorm/$folderName");

            $zip = new ZipArchive;
            if ($zip->open($file->path()) === TRUE) {
                $zip->extractTo($destinationPath);
                $zip->close();
                $scormPath = "scorm/$folderName/index.html";
            } else {
                return back()->with('error', 'No se pudo descomprimir el archivo SCORM.');
            }
        }

        Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $scormPath ?? $request->link,
            'status' => $request->status ?? true,
            'topic_id' => $request->topic_id,
        ]);

        return redirect()->route('activities.index')->with('success', 'Actividad creada exitosamente.');
    }

    public function show($id)
    {
        $activity = Activity::with('topic')->findOrFail($id);
    
        // Verificar si el enlace es una URL externa o un archivo local
        $embedLink = filter_var($activity->link, FILTER_VALIDATE_URL) ? $activity->link : asset($activity->link);
    
        return view('admin.activities.show', compact('activity', 'embedLink'));
    }
    


    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        $topics = Topic::all(); 
        return view('admin.activities.edit', compact('activity', 'topics'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'topic_id' => 'required|exists:topics,id',
            'scorm_file' => 'nullable|mimes:zip',
            'link' => 'nullable|url',
        ]);

        if ($request->hasFile('scorm_file')) {
            if ($activity->link && str_contains($activity->link, 'scorm')) {
                $oldFolder = public_path(dirname($activity->link));
                if (is_dir($oldFolder)) {
                    Storage::deleteDirectory($oldFolder);
                }
            }

            $file = $request->file('scorm_file');
            $folderName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $destinationPath = public_path("scorm/$folderName");

            $zip = new ZipArchive;
            if ($zip->open($file->path()) === TRUE) {
                $zip->extractTo($destinationPath);
                $zip->close();
                $scormPath = "scorm/$folderName/index.html";
            } else {
                return back()->with('error', 'No se pudo descomprimir el archivo SCORM.');
            }
        }

        $activity->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? true,
            'topic_id' => $request->topic_id,
            'link' => $scormPath ?? $request->link,
        ]);

        return redirect()->route('activities.index')->with('success', 'Actividad actualizada exitosamente.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Actividad eliminada exitosamente.');
    }
}
