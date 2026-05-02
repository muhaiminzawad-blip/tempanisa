<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuideController extends Controller
{
    public function index(Request $request)
    {
        $destinationId = $request->query('destination_id');
        $destinations = Destination::orderBy('name')->get();

        $guides = Guide::where('status', 'approved')
            ->when($destinationId, function ($query, $destinationId) {
                return $query->where('destination_id', $destinationId);
            })
            ->where('availability', true)
            ->orderByDesc('experience_years')
            ->get();

        return view('guides.index', compact('guides', 'destinations', 'destinationId'));
    }

    public function show($id)
    {
        $guide = Guide::with(['destination', 'reviews'])->findOrFail($id);
        return view('guides.show', compact('guide'));
    }

    public function create()
    {
        $destinations = Destination::orderBy('name')->get();
        return view('guides.apply', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:guides,email',
            'password' => 'required|min:6|confirmed',
            'experience_years' => 'required|integer|min:0',
            'languages' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'destination_id' => 'nullable|exists:destinations,id',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $photo->getClientOriginalName());
            $uploadDir = public_path('uploads/guides');
            if (! file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $photo->move($uploadDir, $photoName);
            $photoPath = 'uploads/guides/' . $photoName;
        }

        Guide::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $photoPath,
            'experience_years' => $request->experience_years,
            'languages' => $request->languages,
            'specialization' => $request->specialization,
            'price_per_day' => $request->price_per_day,
            'availability' => true,
            'destination_id' => $request->destination_id,
            'bio' => $request->bio,
            'status' => 'pending',
        ]);

        return redirect()->route('guides.index')->with('success', 'Guide application submitted successfully and is now pending admin approval. You will be notified once approved.');
    }
}
