<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Browse Guides</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-cyan-50 via-blue-50 to-indigo-100 text-slate-800 pt-20" style="background-image: url('{{ asset('guide/bg.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">

    <!-- Navbar -->
    <header class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-[95%] md:w-[90%] rounded-3xl backdrop-blur-3xl bg-gradient-to-r from-white/40 via-blue-100/30 to-cyan-100/30 border border-white/60 shadow-2xl">
        <div class="container mx-auto flex justify-between items-center px-6 py-3 relative z-10">
            
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-blue-300 via-cyan-200 to-blue-300 opacity-30 blur-3xl pointer-events-none"></div>

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



            <!-- ✅ Get Started -->
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('login') }}" class="px-5 py-2 text-white bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1 hover:scale-105">
                    Get Started
                </a>
            </div>

            <button class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold">Browse Local Tour Guides</h1>
                <p class="mt-2 text-slate-600">Find approved guides for your destination and book a local expert.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-3xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-[240px_1fr]">
            <aside class="bg-white/50 backdrop-blur-3xl rounded-3xl p-6 shadow-2xl border border-white/70 hover:border-white/90 transition-all duration-300 hover:bg-white/60">
                <h2 class="text-lg font-semibold mb-4">Filter by destination</h2>
                <form action="{{ route('guides.index') }}" method="get" class="space-y-4">
                    <select name="destination_id" class="w-full rounded-xl border border-cyan-200/50 bg-white/60 backdrop-blur-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:bg-white/80 transition" onchange="this.form.submit()">
                        <option value="">All destinations</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ $destinationId == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </form>
            </aside>

            <main class="space-y-6">
                @if($guides->isEmpty())
                    <div class="bg-white/50 backdrop-blur-3xl rounded-3xl shadow-2xl border border-white/70 p-8 text-center">
                        <h2 class="text-2xl font-semibold">No guides found</h2>
                        <p class="mt-2 text-slate-600">Try a different destination or apply to join as a guide.</p>
                    </div>
                @else
                    <div class="grid gap-6">
                        @foreach($guides as $guide)
                            <article class="bg-gradient-to-br from-white/60 via-blue-50/40 to-cyan-50/40 backdrop-blur-3xl rounded-[32px] overflow-hidden shadow-[0_30px_80px_rgba(15,23,42,0.15)] border border-white/80 hover:border-cyan-300/50 ring-1 ring-white/90 flex flex-col md:flex-row gap-6 transition-all duration-300 hover:shadow-[0_40px_100px_rgba(34,211,238,0.25)] hover:bg-gradient-to-br hover:from-white/70 hover:via-cyan-50/50 hover:to-blue-50/50">
                                <div class="h-72 md:h-auto md:w-72 overflow-hidden relative rounded-2xl md:rounded-l-[32px] md:rounded-r-none">
                                    <img src="{{ $guide->photo ? asset($guide->photo) : 'https://via.placeholder.com/500x500?text=Guide' }}" alt="{{ $guide->name }}" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/30 via-blue-950/10 to-transparent"></div>
                                </div>
                                <div class="p-7 flex-1 flex flex-col justify-between gap-5">
                                    <div>
                                        <h3 class="text-3xl font-semibold text-slate-900">{{ $guide->name }}</h3>
                                        <p class="mt-3 text-slate-600 text-base">{{ $guide->specialization }}</p>
                                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                            <div class="rounded-3xl bg-white/70 backdrop-blur-lg border border-cyan-200/50 hover:border-cyan-300 p-4 transition-all hover:bg-white/80">
                                                <p class="text-sm font-medium text-slate-500">Languages</p>
                                                <p class="mt-1 text-slate-900">{{ $guide->languages }}</p>
                                            </div>
                                            <div class="rounded-3xl bg-white/70 backdrop-blur-lg border border-cyan-200/50 hover:border-cyan-300 p-4 transition-all hover:bg-white/80">
                                                <p class="text-sm font-medium text-slate-500">Experience</p>
                                                <p class="mt-1 text-slate-900">{{ $guide->experience_years }} years</p>
                                            </div>
                                        </div>
                                        @if($guide->destination)
                                            <p class="mt-4 text-sm text-slate-500"><strong>Destination:</strong> {{ $guide->destination->name }}</p>
                                        @endif
                                    </div>

                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="rounded-3xl bg-gradient-to-r from-cyan-100/70 to-blue-100/70 backdrop-blur-lg px-4 py-3 border border-cyan-200/70 hover:border-cyan-300">
                                            <span class="text-2xl font-bold text-slate-900">৳ {{ number_format($guide->price_per_day, 2) }}</span>
                                            <span class="block text-sm text-slate-500">per day</span>
                                        </div>
                                        <a href="{{ route('guides.show', $guide->id) }}" class="inline-flex items-center justify-center px-5 py-3 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white hover:shadow-lg hover:shadow-cyan-400/50 hover:scale-105 transition transform">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>
