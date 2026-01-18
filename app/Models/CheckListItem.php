<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nota_type
 * @property int $nota_id
 * @property string $section_id
 * @property int $task_index
 * @property int $is_completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereNotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereNotaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereTaskIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckListItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
