<?php

namespace App\Models;

use App\Models\Concerns\RewritesStorageUrls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use RewritesStorageUrls;

    protected $guarded = [];

    protected $casts = [
        'technologies' => 'array',
        'featured' => 'boolean',
    ];

    public function getImageUrlAttribute(?string $value): ?string
    {
        return $this->rewriteStorageUrl($value);
    }
}
