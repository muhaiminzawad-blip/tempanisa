<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 pt-20">

<!-- HEADER -->
<header class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-[95%] md:w-[90%] rounded-3xl backdrop-blur-xl bg-white/30 border border-white/20 shadow-2xl">

    <div class="container mx-auto flex justify-between items-center px-6 py-3">

        <!-- LOGO -->
        <h1 class="text-2xl font-bold text-blue-600">
            Travel<span class="text-gray-800">Navigator</span>
        </h1>

        <!-- NAV LINKS -->
        @include('partials.navbar')

        <!-- USER + LOGOUT -->
        <div class="flex items-center space-x-4">
            <span class="text-gray-700 font-semibold">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>

    </div>

</header>


<!-- SEARCH SECTION -->
<section class="container mx-auto mt-32 text-center">

    <h2 class="text-3xl font-bold mb-8">Find Your Perfect Room</h2>

    <!-- IMPORTANT: action changed to dashboard -->
    <form action="{{ route('dashboard') }}" method="GET"
          class="bg-white p-6 rounded-2xl shadow-lg grid grid-cols-1 md:grid-cols-5 gap-4">

        <!-- Budget -->
        <div>
            <label class="text-sm text-gray-600">Budget</label>
            <div class="flex gap-2 mt-1">
                <input type="number" name="min_price" placeholder="Min"
                       value="{{ request('min_price') }}"
                       class="w-full p-2 border rounded">

                <input type="number" name="max_price" placeholder="Max"
                       value="{{ request('max_price') }}"
                       class="w-full p-2 border rounded">
            </div>
        </div>

        <!-- Check In -->
        <div>
            <label class="text-sm text-gray-600">Check In</label>
            <input type="date" name="checkin"
                   value="{{ request('checkin') }}"
                   class="w-full p-2 border rounded mt-1">
        </div>

        <!-- Check Out -->
        <div>
            <label class="text-sm text-gray-600">Check Out</label>
            <input type="date" name="checkout"
                   value="{{ request('checkout') }}"
                   class="w-full p-2 border rounded mt-1">
        </div>

        <!-- Guests -->
        <div>
            <label class="text-sm text-gray-600">Guests</label>
            <select name="guests" class="w-full p-2 border rounded mt-1">
                <option value="">Any</option>
                <option value="1" {{ request('guests') == 1 ? 'selected' : '' }}>1 Guest</option>
                <option value="2" {{ request('guests') == 2 ? 'selected' : '' }}>2 Guests</option>
                <option value="3" {{ request('guests') == 3 ? 'selected' : '' }}>3 Guests</option>
                <option value="4" {{ request('guests') == 4 ? 'selected' : '' }}>4+ Guests</option>
            </select>
        </div>

        <!-- Button -->
        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-teal-500 text-white py-2 rounded-full hover:bg-teal-600">
                Search Rooms
            </button>
        </div>

    </form>

</section>


<!-- SEARCH RESULTS (SAME PAGE) -->
@if(isset($rooms))

<section class="container mx-auto mt-10">

    <h3 class="text-2xl font-bold text-center mb-6">
        Available Rooms
    </h3>

    @if($rooms->isEmpty())
        <p class="text-center text-gray-500">No rooms found.</p>
    @else

    <div class="grid md:grid-cols-3 gap-6">

        @foreach($rooms as $room)
        <div class="bg-white rounded-xl shadow p-4">

            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}"
                     class="w-full h-40 object-cover rounded mb-3">
            @endif

            <h2 class="text-lg font-semibold">{{ $room->name }}</h2>

            <p class="text-teal-600 font-bold">
                ৳ {{ number_format($room->price) }}
            </p>

            <p class="text-sm text-gray-500 mt-2">
                {{ \Illuminate\Support\Str::limit($room->description, 80) }}
            </p>

            <a href="/rooms/{{ $room->id }}"
               class="block mt-4 text-center bg-teal-500 text-white py-2 rounded hover:bg-teal-600">
                View Details
            </a>

        </div>
        @endforeach

    </div>

    @endif

</section>

@endif


<!-- TOP DESTINATIONS -->
<section class="container mx-auto mt-10">

    <h3 class="text-2xl font-bold text-center mb-6">Top Destinations</h3>

    <!-- your destination cards -->

</section>


<!-- GUIDES -->
<section id="guides" class="mt-10">
    <!-- your guides -->
</section>


</body>
</html>