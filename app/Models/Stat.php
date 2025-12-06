<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'value',
        'orden',
    ];

    protected $casts = [
        'value' => 'integer',
        'orden' => 'integer',
    ];
}
