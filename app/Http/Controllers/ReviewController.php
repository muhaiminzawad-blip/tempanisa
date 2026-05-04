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
        $user = $request->user();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'guide_id' => $guide->id,
            'user_name' => $user->name ?? 'Guest',
            'user_email' => $user->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('guides.show', $guide->id)
            ->with('success', 'Thank you for your review!');
    }
}
