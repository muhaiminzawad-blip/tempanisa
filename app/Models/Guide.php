<?php

namespace App\Models;

use App\Models\Destination;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guide extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'experience_years',
        'languages',
        'specialization',
        'price_per_day',
        'availability',
        'destination_id',
        'bio',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'availability' => 'boolean',
        'price_per_day' => 'decimal:2',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
