<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckListItem extends Model
{
    protected $fillable = [
        'nota_id',
        'nota_type',
        'section_id',
        'task_index',
        'is_completed'
    ];
}
