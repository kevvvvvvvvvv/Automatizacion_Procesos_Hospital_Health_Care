<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::with('user') 
                              ->latest()
                              ->paginate(25)
                              ->through(fn ($history) => [ 
                                  'id' => $history->id,
                                  'action' => $history->action,
                                  'user_name' => $history->user->name ?? 'Sistema',
                                  'model_name' => class_basename($history->model_type),
                                  'model_id' => $history->model_id,
                                  'before' => $history->before,
                                  'after' => $history->after,
                                  'created_at' => $history->created_at->format('d/m/Y H:i A'),
                              ]);
        
        return Inertia::render('historiales/index',[
            'histories' => $histories
        ]);
    }
}
