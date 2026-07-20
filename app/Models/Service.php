<?php

namespace App\Models;

use App\Models\Concerns\RewritesStorageUrls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use RewritesStorageUrls;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'orden' => 'integer',
    ];

    public function getImageUrlAttribute(?string $value): ?string
    {
        return $this->rewriteStorageUrl($value);
    }
}
