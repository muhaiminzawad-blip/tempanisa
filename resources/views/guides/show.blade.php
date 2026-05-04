<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $guide->name }} - Guide Profile</title>
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
                <a href="{{ route('home') }}#contact">Contact</a>
				
				
            </nav>



            <!-- ✅ Explore + Guide Login -->
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('guide.login') }}" class="px-5 py-2 text-slate-900 bg-white rounded-full shadow-lg hover:bg-slate-100 transition transform hover:-translate-y-1 hover:scale-105">
                    Guide Login
                </a>
                <a href="{{ route('login') }}" class="px-5 py-2 text-white bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1 hover:scale-105">
                    Get Started
                </a>
                <a href="{{ route('guides.apply') }}" class="px-5 py-2 text-blue-600 bg-white rounded-full shadow-lg hover:bg-gray-50 transition transform hover:-translate-y-1 hover:scale-105">
                    Become a Guide
                </a>
            </div>

            <button class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <div class="max-w-6xl mx-auto p-4">
        <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl font-bold">{{ $guide->name }}</h1>
                <p class="mt-2 text-slate-600">{{ $guide->specialization }} · {{ $guide->languages }}</p>
            </div>
            <a href="{{ route('guides.index') }}" class="inline-flex px-5 py-3 rounded-full bg-gray-200 text-slate-700 hover:bg-gray-300 transition">Back to Guides</a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-3xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-3xl bg-red-50 border border-red-200 p-4 text-red-800">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 rounded-3xl bg-red-50 border border-red-200 p-4 text-red-800">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-8 lg:grid-cols-[360px_1fr]">
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-white/60 via-blue-50/40 to-cyan-50/40 backdrop-blur-3xl rounded-3xl shadow-xl border border-white/70 hover:border-cyan-300/50 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:bg-gradient-to-br hover:from-white/70 hover:via-cyan-50/50">
                    <img src="{{ $guide->photo ? asset($guide->photo) : 'https://via.placeholder.com/800x600?text=Guide' }}" alt="{{ $guide->name }}" class="w-full h-72 object-cover">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold">Guide Details</h2>
                        <dl class="mt-4 space-y-3 text-slate-600">
                            <div><span class="font-medium">Experience:</span> {{ $guide->experience_years }} years</div>
                            <div><span class="font-medium">Languages:</span> {{ $guide->languages }}</div>
                            <div><span class="font-medium">Specialization:</span> {{ $guide->specialization }}</div>
                            <div><span class="font-medium">Price:</span> ৳ {{ number_format($guide->price_per_day, 2) }} / day</div>
                            <div><span class="font-medium">Availability:</span> {{ $guide->availability ? 'Available' : 'Booked' }}</div>
                            @if($guide->destination)
                                <div><span class="font-medium">Destination:</span> {{ $guide->destination->name }}</div>
                            @endif
                        </dl>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-white/60 via-blue-50/40 to-cyan-50/40 backdrop-blur-3xl rounded-3xl shadow-xl border border-white/70 p-6 transition-all duration-300 hover:shadow-2xl">
                    <h3 class="text-xl font-semibold text-slate-900 mb-3">About the Guide</h3>
                    <p class="text-slate-600 leading-relaxed">{{ $guide->bio ?: 'No bio provided yet.' }}</p>
                </div>

                <div class="bg-gradient-to-br from-white/60 via-blue-50/40 to-cyan-50/40 backdrop-blur-3xl rounded-3xl shadow-xl border border-white/70 p-6 transition-all duration-300 hover:shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-slate-900">Reviews</h3>
                        <span class="text-slate-500">{{ $guide->reviews->count() }} reviews</span>
                    </div>
                    @if($guide->reviews->isEmpty())
                        <p class="text-slate-500">No reviews yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($guide->reviews as $review)
                                <div class="rounded-3xl border border-slate-200 p-4 bg-slate-50">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="font-semibold">{{ $review->guest_name ?? 'Guest' }}</p>
                                            <p class="text-sm text-slate-500">{{ $review->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="text-yellow-400 font-bold">{{ $review->rating }} ★</div>
                                    </div>
                                    <p class="mt-3 text-slate-600">{{ $review->comment ?: 'No comment provided.' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                @auth
                    <section class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-xl font-semibold mb-4">Hire this guide</h3>
                        <form action="{{ route('guides.hire', $guide->id) }}" method="post" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Preferred date</label>
                                <input type="date" name="date" value="{{ old('date') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Notes</label>
                                <textarea name="notes" rows="4" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center px-5 py-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition">Hire Guide</button>
                        </form>
                    </section>

                    <section class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-xl font-semibold mb-3">Start a chat</h3>
                        <p class="text-slate-600 mb-4">Chat with the guide and ask questions before you travel.</p>
                        <a href="{{ route('guides.chat', $guide->id) }}" class="inline-flex px-5 py-3 rounded-full bg-slate-800 text-white hover:bg-slate-900 transition">Open Chat</a>
                    </section>

                    <section class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-xl font-semibold mb-4">Leave a review</h3>
                        <form action="{{ route('guides.reviews.store', $guide->id) }}" method="post" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Rating</label>
                                <select name="rating" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3">
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Comment</label>
                                <textarea name="comment" rows="4" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3">{{ old('comment') }}</textarea>
                            </div>
                            <button type="submit" class="w-full inline-flex justify-center px-5 py-3 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 transition">Submit Review</button>
                        </form>
                    </section>
                @else
                    <section class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 text-center">
                        <h3 class="text-xl font-semibold mb-2">Login to continue</h3>
                        <p class="text-slate-600 mb-4">You must be logged in to hire, message, or review this guide.</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ route('login') }}" class="inline-flex justify-center px-6 py-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition">Login</a>
                            <a href="{{ route('register') }}" class="inline-flex justify-center px-6 py-3 rounded-full bg-slate-100 text-slate-800 hover:bg-slate-200 transition">Register</a>
                        </div>
                    </section>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
