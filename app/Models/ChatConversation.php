<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_uuid',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'status',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
