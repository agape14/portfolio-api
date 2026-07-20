<?php

namespace App\Models;

use App\Models\Concerns\RewritesStorageUrls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;
    use RewritesStorageUrls;

    protected $fillable = ['name', 'image_url', 'active', 'orden'];

    public function getImageUrlAttribute(?string $value): ?string
    {
        return $this->rewriteStorageUrl($value);
    }
}
