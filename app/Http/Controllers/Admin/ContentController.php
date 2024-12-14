<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Topic;
use App\Traits\Trashable;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContentController extends Controller
{
    use Trashable;
    
    public function datatables($id)
    {
        $contents = Content::where('topic_id', $id)->get();
        return DataTables::of($contents)
            ->addColumn('btn', function ($content) {
                return view('admin.contents.partials.btn', compact('content'))->render();
            })
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function index($topicId)
    {
        $topic = Topic::findOrFail($topicId);
        return view('admin.contents.index', compact('topic'));
    }

    public function create($topic_id)
    {
        $topic = Topic::findOrFail($topic_id);
        return view('admin.contents.create', compact('topic'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'topic_id' => 'required|exists:topics,id',
            'images.*' => 'image|max:2048', // Validación para imágenes
        ]);
    
        $content = Content::create($validatedData);
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $content->addMedia($image)->toMediaCollection('content_images');
            }
        }
    
        return redirect()->route('topics.contents.index', ['topicId' => $validatedData['topic_id']])
            ->with('success', 'Contenido creado correctamente.');
    }

    public function show(Content $content)
    {
        return view('admin.contents.show', compact('content'));
    }

    public function edit($id)
    {
        $content = Content::findOrFail($id);
        $topic = $content->topic;
        return view('admin.contents.edit', compact('content', 'topic'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'topic_id' => 'required|exists:topics,id',
            'images.*' => 'image|max:2048', // Validación para imágenes
        ]);

        $content = Content::findOrFail($id);
        $content->update($validatedData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $content->addMedia($image)->toMediaCollection('content_images');
            }
        }

        return redirect()->route('topics.contents.index', ['topicId' => $validatedData['topic_id']])
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(Content $content)
    {
        $topicId = $content->topic_id;  // Capturamos el topic_id antes de eliminar
        $content->delete();

        return redirect()->route('topics.contents.index', ['topicId' => $topicId])
                            ->with('success', 'Contenido eliminado correctamente!');
    }

    public function moveToTrash($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();
        return redirect()->route('trash.index')->with('success', 'Contenido movido a la papelera.');
    }

    public function restoreFromTrash($id)
    {
        $content = Content::onlyTrashed()->findOrFail($id);
        $content->restore();
        return redirect()->route('trash.index')->with('success', 'Contenido restaurado desde la papelera.');
    }

    public function forceDeleteFromTrash($id)
    {
        $content = Content::onlyTrashed()->findOrFail($id);
        $content->forceDelete();
        return redirect()->route('trash.index')->with('success', 'Contenido eliminado permanentemente.');
    }
}


