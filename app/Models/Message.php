<?php

namespace App\Models;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'sender_name',
        'receiver_name',
        'sender_type',
        'guest_email',
        'message',
    ];

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}
