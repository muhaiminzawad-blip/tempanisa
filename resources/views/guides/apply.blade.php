<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Guide Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 pt-20" style="background-image: url('{{ asset('guide/bg.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">

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
                <a href="{{ route('blogs.index') }}">Blogs</a>
                <a href="#contact">Contact</a>
				
				
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

    <div class="max-w-3xl mx-auto p-4">
        <div class="mb-8">
            <h1 class="text-4xl font-bold">Guide Registration</h1>
            <p class="mt-2 text-slate-600">Apply to become a local tour guide on the platform.</p>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-3xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800">
                {{ session('success') }}
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

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <form action="{{ route('guides.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700">Full name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" required>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Experience (years)</label>
                        <input type="number" name="experience_years" value="{{ old('experience_years') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" min="0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Price per day</label>
                        <input type="number" step="0.01" name="price_per_day" value="{{ old('price_per_day') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" required>
                    </div>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Languages</label>
                        <input type="text" name="languages" value="{{ old('languages') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Specialization</label>
                        <input type="text" name="specialization" value="{{ old('specialization') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Destination</label>
                    <select name="destination_id" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3">
                        <option value="">Select a destination</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Profile photo</label>
                    <input type="file" name="photo" class="mt-2 w-full text-slate-700">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Bio</label>
                    <textarea name="bio" rows="5" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3">{{ old('bio') }}</textarea>
                </div>
                <button type="submit" class="inline-flex w-full justify-center rounded-full bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">Submit Application</button>
            </form>
        </div>
    </div>
</body>
</html>
