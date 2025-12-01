<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HojaEnfermeriaQuirofano extends Model
{
    
    public $incrementing = false;
    protected $fillable = [
        'id'
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    public function hojaGeneral():HasOne
    {
        return $this->hasOne(HojaGeneral::class);
    }
}
