<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Booking;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuideAuthController extends Controller
{
    public function showLogin()
    {
        return view('guide.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $guide = Guide::where('email', $request->email)->first();

        if ($guide && Hash::check($request->password, $guide->password) && $guide->status === 'approved') {
            session(['guide_id' => $guide->id]);
            return redirect('/guide/dashboard');
        }

        return back()->with('error', 'Invalid credentials or account not approved.');
    }

    public function logout()
    {
        session()->forget('guide_id');
        return redirect('/guide/login');
    }

    public function dashboard()
    {
        $guide = Guide::with(['bookings', 'messages'])->findOrFail(session('guide_id'));

        return view('guide.dashboard', compact('guide'));
    }

    public function confirmBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure the booking belongs to the logged-in guide
        if ($booking->guide_id != session('guide_id')) {
            return redirect('/guide/dashboard')->with('error', 'Unauthorized access.');
        }

        $booking->update(['status' => 'confirmed']);

        return redirect('/guide/dashboard')->with('success', 'Booking confirmed.');
    }

    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->guide_id != session('guide_id')) {
            return redirect('/guide/dashboard')->with('error', 'Unauthorized access.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect('/guide/dashboard')->with('success', 'Booking cancelled.');
    }

    public function completeBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->guide_id != session('guide_id')) {
            return redirect('/guide/dashboard')->with('error', 'Unauthorized access.');
        }

        $booking->update(['status' => 'completed']);

        return redirect('/guide/dashboard')->with('success', 'Booking marked as completed.');
    }

    public function chatWithGuest($email)
    {
        $guide = Guide::findOrFail(session('guide_id'));

        $messages = Message::where('guide_id', $guide->id)
            ->where('guest_email', $email)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('guide.chat', compact('guide', 'messages', 'email'));
    }
}
