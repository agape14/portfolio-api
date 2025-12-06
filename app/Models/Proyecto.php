<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen_url',
        'url_proyecto',
        'tecnologias',
        'orden',
        'destacado',
    ];

    protected $casts = [
        'tecnologias' => 'array',
        'destacado' => 'boolean',
        'orden' => 'integer',
    ];
}

