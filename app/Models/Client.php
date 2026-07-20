<?php

namespace App\Models;

use App\Models\Concerns\RewritesStorageUrls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    use RewritesStorageUrls;

    protected $guarded = [];

    public function getLogoUrlAttribute(?string $value): ?string
    {
        return $this->rewriteStorageUrl($value);
    }
}
