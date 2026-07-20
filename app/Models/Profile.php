<?php

namespace App\Models;

use App\Models\Concerns\RewritesStorageUrls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    use RewritesStorageUrls;

    protected $fillable = [
        'name',
        'headline',
        'github_url',
        'contact_email',
        'linkedin_url',
        'twitter_url',
        'instagram_url',
        'bio',
        'profile_picture_url',
    ];

    public function getProfilePictureUrlAttribute(?string $value): ?string
    {
        return $this->rewriteStorageUrl($value);
    }
}
