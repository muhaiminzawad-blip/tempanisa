<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guide;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, $guideId)
    {
        $guide = Guide::findOrFail($guideId);
        $user = $request->user();

        $request->validate([
            'date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        Booking::create([
            'guide_id' => $guide->id,
            'destination_id' => $guide->destination_id,
            'guest_name' => $user->name ?? 'Guest',
            'guest_email' => $user->email,
            'date' => $request->date,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('guides.show', $guide->id)
            ->with('success', 'Your hiring request has been submitted! The guide will see your booking request in their dashboard and can confirm or contact you directly.');
    }
}