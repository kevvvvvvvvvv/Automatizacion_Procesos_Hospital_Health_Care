<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckListItem;

class CheckListController extends Controller
{
    public function toggle(Request $request) {
    $validated = $request->validate([
        'nota_id' => 'required|integer',
        'nota_type' => 'required|string', 
        'section_id' => 'required|string',
        'task_index' => 'required|integer',
        'is_completed' => 'required|boolean',
    ]);

    $item = ChecklistItem::updateOrCreate(
        [
            'nota_id' => $validated['nota_id'],
            'nota_type' => $validated['nota_type'],
            'section_id' => $validated['section_id'],
            'task_index' => $validated['task_index'],
        ],
        ['is_completed' => $validated['is_completed']]
    );

    return response()->json(['status' => 'success']);
}
}
