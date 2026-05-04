<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with {{ $guide->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-cyan-50 to-indigo-50 pt-20">
    <!-- Navbar -->
    <header class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-[95%] md:w-[90%] rounded-3xl backdrop-blur-3xl bg-white/40 border border-white/60 shadow-2xl">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <h1 class="text-2xl font-extrabold text-blue-600">
                Travel<span class="text-gray-800">Navigator</span>
            </h1>
            @include('partials.navbar')
            <a href="{{ route('guides.index') }}" class="px-5 py-2 text-blue-600 bg-white/80 rounded-full shadow-lg hover:bg-white transition">Back</a>
        </div>
    </header>

    <div class="max-w-5xl mx-auto p-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-gray-800">Chat with {{ $guide->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $guide->specialization }} · Experience: {{ $guide->experience_years }} years</p>
        </div>

        <!-- Chat Container -->
        <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
            <!-- Guide Info Card -->
            <div class="backdrop-blur-xl bg-white/40 rounded-3xl shadow-xl border border-white/60 p-6 h-fit">
                <img src="{{ $guide->photo ? asset($guide->photo) : 'https://via.placeholder.com/300x300?text=Guide' }}" alt="{{ $guide->name }}" class="w-full h-48 object-cover rounded-2xl mb-4">
                <h2 class="text-2xl font-bold text-gray-800">{{ $guide->name }}</h2>
                <p class="text-sm text-gray-600 mt-2">{{ $guide->specialization }}</p>
                <dl class="mt-4 space-y-2 text-sm">
                    <div><span class="font-semibold text-gray-700">Languages:</span> <span class="text-gray-600">{{ $guide->languages }}</span></div>
                    <div><span class="font-semibold text-gray-700">Experience:</span> <span class="text-gray-600">{{ $guide->experience_years }} years</span></div>
                    <div><span class="font-semibold text-gray-700">Price:</span> <span class="text-gray-600">৳ {{ number_format($guide->price_per_day, 2) }} / day</span></div>
                </dl>
            </div>

            <!-- Chat Messages -->
            <div class="flex flex-col h-[600px] backdrop-blur-xl bg-gradient-to-b from-white/50 to-white/30 rounded-3xl shadow-xl border border-white/60 overflow-hidden">
                <!-- Messages Area -->
                <div id="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-4">
                    <div class="text-center text-gray-500">
                        <p>Start your conversation with {{ $guide->name }}</p>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="border-t border-white/40 p-4 bg-white/20">
                    <form id="messageForm" class="flex gap-3">
                        <input 
                            type="text" 
                            id="messageInput" 
                            placeholder="Type your message..." 
                            class="flex-1 px-4 py-3 rounded-full bg-white/60 border border-white/80 backdrop-blur-lg placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white/80 transition"
                            required
                        >
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-full font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition transform"
                        >
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const guideId = {{ $guide->id }};
        const guestEmail = {!! json_encode(auth()->user()->email) !!};

        async function loadMessages() {
            try {
                const response = await axios.get(`/guides/${guideId}/messages?email=${guestEmail}`);
                const container = document.getElementById('messagesContainer');
                
                if (response.data.length === 0) {
                    container.innerHTML = '<div class="text-center text-gray-500">Start your conversation with {{ $guide->name }}</div>';
                    return;
                }

                container.innerHTML = response.data.map(msg => `
                    <div class="flex ${msg.sender_type === 'user' ? 'justify-end' : 'justify-start'}">
                        <div class="max-w-xs backdrop-blur-lg ${msg.sender_type === 'user' 
                            ? 'bg-gradient-to-r from-blue-400 to-cyan-400 text-white' 
                            : 'bg-white/50 border border-white/80 text-gray-800'} rounded-3xl px-4 py-3 shadow-lg">
                            <p class="text-sm font-semibold mb-1">${msg.sender_name}</p>
                            <p class="text-sm">${msg.message}</p>
                        </div>
                    </div>
                `).join('');
                
                // Scroll to bottom
                container.scrollTop = container.scrollHeight;
            } catch (error) {
                console.error('Error loading messages:', error);
            }
        }

        document.getElementById('messageForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (!message) return;

            try {
                await axios.post(`/guides/${guideId}/messages`, {
                    sender_name: {!! json_encode(auth()->user()->name ?? 'Guest') !!},
                    receiver_name: {!! json_encode($guide->name) !!},
                    guest_email: guestEmail,
                    message: message,
                    sender_type: 'user'
                });
                
                input.value = '';
                await loadMessages();
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message');
            }
        });

        // Load messages on page load and refresh every 2 seconds
        loadMessages();
        setInterval(loadMessages, 2000);
    </script>
</body>
</html>
