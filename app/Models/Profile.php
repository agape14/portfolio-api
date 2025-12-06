<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

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
}
