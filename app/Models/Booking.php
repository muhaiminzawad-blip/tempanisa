<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'destination_id',
        'guest_name',
        'guest_email',
        'date',
        'notes',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
