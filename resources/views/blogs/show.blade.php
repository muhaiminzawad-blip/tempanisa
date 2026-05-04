<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }}</title>

    <!-- Tailwind + Typography -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
</head>

<body class="bg-gray-100 text-gray-800 pt-20">

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

            <div class="hidden md:flex space-x-4">
                <a href="#" class="px-5 py-2 text-white bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1 hover:scale-105">
                    Get Started
                </a>
            </div>

            <button class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative bg-cover bg-center h-[50vh]" 
    style="background-image: url('{{ $blog->image }}');">

        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-white text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold">{{ $blog->title }}</h1>
            <p class="mt-2 text-lg">{{ $blog->category }}</p>
        </div>

    </section>

    <!-- Content -->
    <div class="container mx-auto py-12 px-4 max-w-4xl">

        <a href="{{ route('blogs.index') }}" 
           class="text-blue-600 hover:underline mb-6 inline-block">
            ← Back to Blogs
        </a>

        <div class="bg-white rounded-xl shadow p-8">

            <p class="text-gray-500 text-sm mb-6">
                By {{ $blog->author }} • 
                {{ $blog->created_at ? $blog->created_at->format('F d, Y') : '' }}
            </p>

            <!-- ✅ FIXED CONTENT DISPLAY -->
            <div class="prose max-w-none">
                {!! $blog->content !!}
            </div>

        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-6 mt-12 text-center">
        <p>&copy; {{ date('Y') }} Travel Navigator Explorer</p>
    </footer>

</body>
</html>