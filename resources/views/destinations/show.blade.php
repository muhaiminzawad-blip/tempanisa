<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $destination->name }} - Cox’s Bazar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-200 via-sky-100 to-blue-50 font-sans">

<div class="w-full">

    <!-- Navbar -->
    <header class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-[95%] md:w-[90%] rounded-3xl backdrop-blur-xl bg-white/30 border border-white/20 shadow-2xl">
        <div class="container mx-auto flex justify-between items-center px-6 py-3 relative z-10">
            
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-blue-400 via-cyan-300 to-blue-500 opacity-20 blur-3xl pointer-events-none"></div>

            <h1 class="relative text-2xl font-extrabold text-blue-600">
                Travel<span class="text-gray-800">Navigator</span>
            </h1>

            <nav class="hidden md:flex items-center space-x-8 text-gray-700">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('destinations.index') }}">Destinations</a>
                <a href="{{ route('guides.index') }}">Guides</a>
                <a href="{{ route('explore.index') }}">Explore</a>
                <a href="{{ route('blogs.index') }}">Blogs</a>
                <a href="#contact">Contact</a>
            </nav>

            <!-- ✅ Only Get Started Button remains -->
            <div class="hidden md:flex space-x-4">
                <a href="#" class="px-5 py-2 text-white bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1 hover:scale-105">
                    Get Started
                </a>
            </div>

            <button class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <!-- Main Section -->
    <div class="w-full bg-white/95 backdrop-blur-lg shadow-2xl overflow-hidden">

        <!-- Hero Image -->
        <div class="relative">
            <img src="{{ $destination->image ?? 'https://via.placeholder.com/1600x600' }}"
                 alt="{{ $destination->name }}"
                 class="w-full h-[320px] md:h-[500px] lg:h-[650px] object-cover">

            <!-- Category -->
            <span class="absolute bottom-6 left-6 bg-blue-600 text-white px-8 py-3 rounded-full shadow-lg text-xl md:text-1xl lg:text-2xl">
                {{ $destination->category }}
            </span>
        </div>

        <!-- Content -->
        <div class="px-4 md:px-10 lg:px-20 py-10 space-y-8">

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-800 leading-tight">
                {{ $destination->name }}
            </h1>

            <!-- ⭐ Rating (FIXED) -->
            <div class="flex items-center gap-3">
                @php
                    $rating = round($destination->rating ?? 0, 1);
                    $fullStars = floor($rating);
                    $emptyStars = 5 - $fullStars;
                @endphp

                <div class="flex text-yellow-400 text-2xl">
                    @for($i = 0; $i < $fullStars; $i++)
                        ★
                    @endfor

                    @for($i = 0; $i < $emptyStars; $i++)
                        <span class="text-gray-300">★</span>
                    @endfor
                </div>

                <span class="text-gray-600 text-lg font-medium">
                    {{ $rating }} / 5
                </span>
            </div>

            <!-- Description -->
            <div class="max-w-5xl">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">About</h2>
                @if($destination->description)
                    <p class="text-gray-600 text-lg leading-relaxed">
                        {{ $destination->description }}
                    </p>
                @else
                    <p class="text-gray-400 italic">No description available.</p>
                @endif
            </div>

            <!-- Info Section -->
            <div class="grid md:grid-cols-2 gap-8 max-w-5xl">
                <div class="bg-blue-50 p-6 rounded-xl shadow-inner">
                    <h3 class="font-semibold text-gray-700 mb-2">🎯 Attractions</h3>
                    @if($destination->attractions)
                        <p class="text-gray-600">{{ $destination->attractions }}</p>
                    @else
                        <p class="text-gray-400 italic">No attractions listed.</p>
                    @endif
                </div>

                <div class="bg-blue-50 p-6 rounded-xl shadow-inner">
                    <h3 class="font-semibold text-gray-700 mb-2">📅 Best Time to Visit</h3>
                    @if($destination->best_time)
                        <p class="text-gray-600">{{ $destination->best_time }}</p>
                    @else
                        <p class="text-gray-400 italic">Not specified.</p>
                    @endif
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('destinations.index') }}"
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full font-semibold transition">
                   ← Back
                </a>

                <a href="{{ route('destinations.index') }}?query={{ urlencode($destination->category) }}"
                   target="_blank"
                   class="px-6 py-3 bg-gradient-to-r from-blue-500 to-sky-400 text-white rounded-full font-semibold hover:from-blue-600 hover:to-sky-500 transition">
                   Explore Similar ↗
                </a>
            </div>

        </div>
    </div>

    <!-- Related Destinations -->
    @if(isset($related) && $related->count())
        <div class="px-4 md:px-10 lg:px-16 py-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">You may also like</h2>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($related as $item)
                    <a href="/destinations/{{ $item->id }}"
                       class="bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition duration-300">

                        <div class="h-52">
                            <img src="{{ $item->image ?? 'https://via.placeholder.com/300' }}"
                                 class="w-full h-full object-cover">
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $item->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->category }}</p>

                            <!-- ⭐ Rating (FIXED) -->
                            @php
                                $rating = round($item->rating ?? 0, 1);
                            @endphp

                            <div class="text-yellow-400 mt-1 text-sm font-medium">
                                ★ {{ $rating }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

</body>
</html>