<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Content;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        $trashedUsers = User::onlyTrashed()->get();
        $trashedTopics = Topic::onlyTrashed()->get();
        $trashedContents = Content::onlyTrashed()->get();
        $trashedActivities = Activity::onlyTrashed()->get();

        return view('admin.trash.index', compact('trashedUsers', 'trashedTopics', 'trashedContents', 'trashedActivities'));
    }

    public function moveToTrash($model, $id)
    {
        $modelInstance = $this->findModelInstance($model, $id);
        if ($modelInstance) {
            $modelInstance->delete();
            return redirect()->back()->with('success', 'Elemento movido a la papelera.');
        }
        return redirect()->back()->with('error', 'Elemento no encontrado.');
    }

    public function restoreFromTrash($model, $id)
    {
        $modelInstance = $this->findModelInstance($model, $id, true);
        if ($modelInstance) {
            $modelInstance->restore();
            return redirect()->back()->with('success', 'Elemento restaurado desde la papelera.');
        }
        return redirect()->back()->with('error', 'Elemento no encontrado.');
    }

    public function forceDeleteFromTrash($model, $id)
    {
        $modelInstance = $this->findModelInstance($model, $id, true);
        if ($modelInstance) {
            $modelInstance->forceDelete();
            return redirect()->back()->with('success', 'Elemento eliminado permanentemente.');
        }
        return redirect()->back()->with('error', 'Elemento no encontrado.');
    }

    private function findModelInstance($model, $id, $withTrashed = false)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);
        if (class_exists($modelClass)) {
            return $withTrashed ? $modelClass::withTrashed()->find($id) : $modelClass::find($id);
        }
        return null;
    }
}
