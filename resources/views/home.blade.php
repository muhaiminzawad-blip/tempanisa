<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Navigator Explorer - Cox's Bazar</title>
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
                <a href="{{ route('login') }}" class="px-5 py-2 text-white bg-blue-600 rounded-full">
                    Get Started
                </a>
            </div>

            <button class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[80vh]" style="background-image: url('https://i.pinimg.com/736x/3f/31/60/3f31601947c498388838683c88aad8c4.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center text-white p-4">
            <h2 class="text-4xl md:text-6xl font-bold mb-4">Explore Cox's Bazar</h2>
            <p class="text-lg md:text-2xl mb-6">Plan your perfect beach gateway in Bangladesh</p>
        </div>
    </section>

    <!-- Destinations -->
    <section id="destinations" class="py-12 container mx-auto">
        <h3 class="text-3xl font-bold text-center mb-8">Top Destinations in Cox's Bazar</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Inani_Beach_in_the_day_%2821_February_2014%29.jpg/250px-Inani_Beach_in_the_day_%2821_February_2014%29.jpg" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="font-bold text-xl">Inani Beach</h4>
                    <p class="text-gray-600">Famous for coral stones and serene views.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <img src="https://i.pinimg.com/1200x/a5/1e/98/a51e98ee43b4599653b85a1fc38d2579.jpg" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="font-bold text-xl">Himchari National Park</h4>
                    <p class="text-gray-600">Waterfalls, hills, and wildlife.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/ea/Spring_Lake%2C_New_Jersey_Beach_at_Sunrise.jpg" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="font-bold text-xl">Sea Beach</h4>
                    <p class="text-gray-600">World’s longest sandy beach.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Guides -->
    <section id="guides" class="py-12 bg-gray-50">
        <h3 class="text-3xl font-bold text-center mb-8">Hire Local Tour Guides</h3>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-xl shadow p-4 text-center">
                <img src="https://i.pinimg.com/736x/02/c7/85/02c785ccea228c49562ae325d74c7007.jpg" class="w-32 h-32 rounded-full mx-auto mb-4">
                <h4 class="font-bold text-xl">Rahim Uddin</h4>
                <p class="text-gray-600">৳1500/day</p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 text-center">
                <img src="https://i.pinimg.com/1200x/b9/99/ce/b999ce3b1ad833a3eb760a742252eafe.jpg" class="w-32 h-32 rounded-full mx-auto mb-4">
                <h4 class="font-bold text-xl">Fatima Begum</h4>
                <p class="text-gray-600">৳2000/day</p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 text-center">
                <img src="https://i.pinimg.com/736x/f3/c3/13/f3c313e23a8d810207f615a1b5ee279e.jpg" class="w-32 h-32 rounded-full mx-auto mb-4">
                <h4 class="font-bold text-xl">Jahid Hasan</h4>
                <p class="text-gray-600">৳1200/day</p>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-6 mt-12 text-center">
        <p>&copy; {{ date('Y') }} Travel Navigator Explorer</p>
    </footer>

</body>
</html>