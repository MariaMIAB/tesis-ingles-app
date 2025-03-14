<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\StoreRequest;
use App\Http\Requests\Topic\UpdateRequest;
use App\Models\Semester;
use App\Models\Topic;
use App\Models\TopicLike;
use App\Models\TopicView;
use App\Models\Year;
use App\Traits\Trashable;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{
    use Trashable;

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

    public function index()
    {
        $topics = Topic::withCount('activities')->get();
        return view('admin.topics.index', compact('topics'));
    }

    public function create()
    {
        $topic = new Topic();
        $years = Year::orderBy('name', 'asc')->get();
        return view('admin.topics.create', compact('topic', 'years'));
    }
    
    public function getSemestersByYear($yearId)
    {
        $semesters = Semester::where('year_id', $yearId)->get();
        return response()->json($semesters);
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        Topic::create($validatedData);
        return redirect()->route('topics.index')->with('success', 'Topic created successfully!');
    }

    public function show(string $id)
    {
        $topic = Topic::with(['views', 'likes'])->findOrFail($id);
        return view('admin.topics.show', compact('topic'));
    }

    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        $years = Year::with('semesters')->orderBy('name', 'asc')->get();
        return view('admin.topics.edit', compact('topic', 'years'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $topic = Topic::findOrFail($id);
        $topic->update($validatedData);
        return redirect()->route('topics.show', $topic->id)->with('success', 'Tema actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return redirect()->route('topics.index')->with('success', 'Topic deleted successfully!');
    }

    public function toggleView(Request $request, $topic_id)
    {
        $view = TopicView::where('user_id', $request->user()->id)
                        ->where('topic_id', $topic_id)
                        ->first();

        if ($view) {
            $view->delete();
            return redirect()->back()->with('success', 'Vista eliminada');
        } else {
            TopicView::create([
                'user_id' => $request->user()->id,
                'topic_id' => $topic_id,
            ]);
            return redirect()->back()->with('success', 'Ver grabado');
        }
    }

    public function storeView(Request $request, $topic_id)
    {
        $existingView = TopicView::where('user_id', $request->user()->id)->where('topic_id', $topic_id)->first();

        if ($existingView) {
            $existingView->delete();
            return redirect()->back()->with('success', 'Visto eliminada');
        } else {
            TopicView::create([
                'user_id' => $request->user()->id,
                'topic_id' => $topic_id,
            ]);
            return redirect()->back()->with('success', 'Visto guardada');
        }
    }

    public function storeLike(Request $request, $topic_id)
    {
        $existingLike = TopicLike::where('user_id', $request->user()->id)->where('topic_id', $topic_id)->first();

        if ($existingLike) {
            $existingLike->delete();
            return redirect()->back()->with('success', 'Me gusta eliminado');
        } else {
            TopicLike::create([
                'user_id' => $request->user()->id,
                'topic_id' => $topic_id,
            ]);
            return redirect()->back()->with('success', 'Me gusta recordado');
        }
    }

    public function moveToTrash($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return redirect()->route('trash.index')->with('success', 'Tema movido a la papelera.');
    }

    public function restoreFromTrash($id)
    {
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->restore();
        return redirect()->route('trash.index')->with('success', 'Tema restaurado desde la papelera.');
    }

    public function forceDeleteFromTrash($id)
    {
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->forceDelete();
        return redirect()->route('trash.index')->with('success', 'Tema eliminado permanentemente.');
    }
}

