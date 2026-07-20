<?php

namespace App\Models;

use App\Models\Concerns\RewritesStorageUrls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    use RewritesStorageUrls;

    protected $fillable = ['name', 'role', 'quote', 'rating', 'avatar_url', 'active', 'orden'];

    public function getAvatarUrlAttribute(?string $value): ?string
    {
        return $this->rewriteStorageUrl($value);
    }
}
