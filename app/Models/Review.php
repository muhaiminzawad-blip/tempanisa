<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'user_name',
        'user_email',
        'rating',
        'comment',
    ];

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}
