<?php

namespace App\Traits;

trait Trashable
{
    public function moveToTrash($model)
    {
        if (method_exists($model, 'trashed') && !$model->trashed()) {
            $model->delete();
        }
    }

    public function restoreFromTrash($model)
    {
        if (method_exists($model, 'trashed') && $model->trashed()) {
            $model->restore();
        }
    }

    public function forceDeleteFromTrash($model)
    {
        if (method_exists($model, 'trashed') && $model->trashed()) {
            $model->forceDelete();
        }
    }
}
