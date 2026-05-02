<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $guideId)
    {
        $guide = Guide::findOrFail($guideId);

        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'guide_id' => $guide->id,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('guides.show', $guide->id)
            ->with('success', 'Thank you for your review!');
    }
}
