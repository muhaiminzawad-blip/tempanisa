<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function show($guideId)
    {
        $guide = Guide::findOrFail($guideId);
        return view('chat.show', compact('guide'));
    }

    public function index(Request $request, $guideId)
    {
        $guestEmail = $request->query('email');

        $messages = Message::where('guide_id', $guideId)
            ->when($guestEmail, function ($query, $guestEmail) {
                return $query->where('guest_email', $guestEmail);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function store(Request $request, $guideId)
    {
        $guide = Guide::findOrFail($guideId);

        $request->validate([
            'sender_name' => 'required|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'message' => 'required|string|max:2000',
            'sender_type' => 'required|in:user,guide',
        ]);

        Message::create([
            'guide_id' => $guide->id,
            'sender_name' => $request->sender_name,
            'receiver_name' => $request->receiver_name,
            'sender_type' => $request->sender_type,
            'guest_email' => $request->guest_email,
            'message' => $request->message,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}
