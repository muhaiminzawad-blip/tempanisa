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

        $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        Booking::create([
            'guide_id' => $guide->id,
            'destination_id' => $guide->destination_id,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'date' => $request->date,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('guides.show', $guide->id)
            ->with('success', 'Your hiring request has been submitted! The guide will see your booking request in their dashboard and can confirm or contact you directly.');
    }
}