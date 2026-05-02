<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Details - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-6">
                <h2 class="text-2xl font-bold">Admin Panel</h2>
            </div>
            <nav class="mt-6">
                <a href="/admin/dashboard" class="block px-6 py-3 hover:bg-blue-700">Dashboard</a>
                <a href="/admin/guides" class="block px-6 py-3 bg-blue-900">Manage Guides</a>
                <a href="/admin/logout" class="block px-6 py-3 hover:bg-blue-700 mt-8">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">Guide Details</h1>
                <a href="/admin/guides" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to Guides</a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex items-start space-x-6">
                    <img src="{{ $guide->photo ? asset($guide->photo) : 'https://via.placeholder.com/150x150?text=Guide' }}" alt="{{ $guide->name }}" class="w-32 h-32 rounded-full object-cover">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $guide->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ $guide->specialization }}</p>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $guide->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="mt-1 px-2 py-1 text-xs font-semibold rounded-full inline-block
                                    @if($guide->status == 'approved') bg-green-100 text-green-800
                                    @elseif($guide->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($guide->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Experience</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $guide->experience_years }} years</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price per Day</label>
                                <p class="mt-1 text-sm text-gray-900">৳ {{ number_format($guide->price_per_day, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Languages</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $guide->languages }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Destination</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $guide->destination ? $guide->destination->name : 'N/A' }}</p>
                            </div>
                        </div>

                        @if($guide->bio)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700">Bio</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $guide->bio }}</p>
                            </div>
                        @endif

                        @if($guide->status == 'pending')
                            <div class="mt-8 flex space-x-4">
                                <a href="/admin/guides/{{ $guide->id }}/approve" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Approve Guide</a>
                                <a href="/admin/guides/{{ $guide->id }}/reject" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">Reject Guide</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>