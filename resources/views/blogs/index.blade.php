<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Blogs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 pt-20">

    <!-- Navbar -->
    <header class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-[95%] md:w-[90%] rounded-3xl backdrop-blur-xl bg-white/30 border border-white/20 shadow-2xl">
        <div class="container mx-auto flex justify-between items-center px-6 py-3 relative z-10">
            
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-blue-400 via-cyan-300 to-blue-500 opacity-20 blur-3xl pointer-events-none"></div>

            <h1 class="relative text-2xl font-extrabold text-blue-600">
                Travel<span class="text-gray-800">Navigator</span>
            </h1>

            @include('partials.navbar')

            <div class="hidden md:flex space-x-4">
                <a href="#" class="px-5 py-2 text-white bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1 hover:scale-105">
                    Get Started
                </a>
            </div>

            <button class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative bg-cover bg-center h-[60vh]" 
    style="background-image: url('https://i.pinimg.com/736x/3f/31/60/3f31601947c498388838683c88aad8c4.jpg');">
        
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Travel Blogs</h1>
            <p class="text-lg md:text-2xl">Stories, tips & guides for your journey</p>
        </div>

    </section>

    <!-- Blog Section -->
    <section class="py-12 container mx-auto px-4">

        <h2 class="text-3xl font-bold text-center mb-8">Latest Articles</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @foreach($blogs as $blog)
            <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-2xl transition duration-300">

                <img src="{{ $blog->image }}" class="w-full h-48 object-cover">

                <div class="p-4">

                    <span class="text-xs text-blue-600 font-semibold uppercase">
                        {{ $blog->category }}
                    </span>

                    <h4 class="font-bold text-xl mt-1">
                        {{ $blog->title }}
                    </h4>

                    <p class="text-gray-600 text-sm mt-2">
                        {{ Str::limit(strip_tags($blog->content), 100) }}
                    </p>

                    <a href="{{ route('blogs.show', $blog->id) }}"
                       class="inline-block mt-3 text-blue-600 hover:underline">
                        Read More →
                    </a>

                </div>
            </div>
            @endforeach

        </div>

    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-6 mt-12 text-center">
        <p>&copy; {{ date('Y') }} Travel Navigator Explorer</p>
    </footer>

</body>
</html>