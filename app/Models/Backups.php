<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Backups extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'path',
        'status',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','idusuario');
    }
    
}
