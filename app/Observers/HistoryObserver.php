<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\History;

class HistoryObserver
{
    public function created(Model $model): void
    {
        $this->logAction('created', $model);
    }

    public function updated(Model $model): void
    {
        $dirty = $model->getDirty();

        if (empty($dirty)) {
            return;
        }

        History::create([
            'user_id'    => Auth::id(),
            'model_type' => get_class($model),
            'model_id'   => $model->getKey(),
            'action'     => 'updated',
            'before'     => json_encode(array_intersect_key($model->getOriginal(), $dirty)),
            'after'      => json_encode($dirty),
        ]);
    }

    public function deleted(Model $model): void
    {
        $this->logAction('deleted', $model);
    }
    
    protected function logAction(string $action, Model $model): void
    {
        History::create([
            'user_id'    => Auth::id(),
            'model_type' => get_class($model),
            'model_id'   => $model->getKey(),
            'action'     => $action,
            'before'     => $action !== 'created' ? json_encode($model->getOriginal()) : null,
            'after'      => $action !== 'deleted' ? json_encode($model->getAttributes()) : null,
        ]);
    }
}
