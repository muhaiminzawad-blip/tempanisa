<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cox’s Bazar Tourism Spots</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-500 via-sky-400 to-blue-300 min-h-screen font-sans flex items-center justify-center"
      style="background-image: url('https://i.pinimg.com/1200x/70/73/27/707327c07ff1a9666bb6eaa8b1cc279b.jpg'); 
             background-size: cover; 
             background-position: center; 
             background-attachment: fixed;">
    
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

<div class="w-full max-w-lg">

    <h1 class="text-4xl font-bold text-white text-center mb-6 drop-shadow-lg">
        🌴 Explore Cox’s Bazar
    </h1>

    <!-- Search + Filter -->
    <div class="relative backdrop-blur-lg bg-white/80 p-4 rounded-xl shadow-xl">

        <!-- Search Input -->
        <div class="relative">
            <span class="absolute left-3 top-3 text-gray-400">🔍</span>

            <input type="text" id="searchQuery"
                placeholder="Search beaches, islands, places..."
                class="w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">

            <button id="clearBtn"
                class="absolute right-3 top-3 text-gray-400 hidden hover:text-red-500">
                ✕
            </button>
        </div>

        <!-- Category Filter -->
        <div class="mt-4">
            <select id="categoryFilter"
                class="w-full px-3 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">All Categories</option>
                <option value="beach">Beach</option>
                <option value="island">Island</option>
                <option value="hill">Hill</option>
                <option value="nature">Nature</option>
                <option value="waterfall">Waterfall</option>
                <option value="cultural">Cultural</option>
                <option value="eco">Eco</option>
                <option value="adventure">Adventure</option>
            </select>
        </div>

        <div id="loading" class="text-center text-sm text-gray-500 mt-2 hidden">
            🔄 Searching...
        </div>

        <!-- Results -->
        <div id="results"
            class="absolute left-0 right-0 bg-white mt-3 rounded-xl shadow-xl max-h-96 overflow-y-auto hidden z-50">
        </div>
    </div>
</div>

<script>
const searchInput = document.getElementById('searchQuery');
const resultsDiv = document.getElementById('results');
const loading = document.getElementById('loading');
const clearBtn = document.getElementById('clearBtn');
const categoryFilter = document.getElementById('categoryFilter');

let debounceTimer;
let currentResults = [];
let activeIndex = -1;

window.onload = function () {
    const params = new URLSearchParams(window.location.search);
    const query = params.get('query');
    const category = params.get('category');

    if (query) {
        searchInput.value = query;
        search(query, category);
    }
};

function highlight(text) {
    return text ?? '';
}

function truncate(text, maxLength = 100) {
    return text?.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

// ✅ UPDATED: rating added
function renderResults(data) {
    currentResults = data;
    activeIndex = -1;

    resultsDiv.classList.remove('hidden');

    if (!data.length) {
        resultsDiv.innerHTML = `
            <div class="p-6 text-center text-gray-500">
                😕 No destinations found
            </div>`;
        return;
    }

    resultsDiv.innerHTML = data.map((d, i) => `
        <div data-id="${d.id}"
            class="flex items-start gap-3 p-3 hover:bg-blue-50 cursor-pointer transition rounded-lg">

            <img src="${d.image ?? 'https://via.placeholder.com/60'}"
                class="w-14 h-14 rounded-lg object-cover shadow">

            <div>
                <p class="font-semibold text-gray-800">${highlight(d.name)}</p>
                <p class="text-xs text-blue-500 font-medium">${highlight(d.category)}</p>

                <!-- ⭐ Rating -->
                <p class="text-xs text-yellow-500 font-semibold">
                    ⭐ ${d.rating ?? 0} / 5
                </p>

                <p class="text-sm text-gray-600">${truncate(d.description)}</p>
            </div>
        </div>
    `).join('');

    resultsDiv.querySelectorAll('div[data-id]').forEach((el, i) => {
        el.addEventListener('click', () => {
            window.location.href = `/destinations/${data[i].id}`;
        });
    });
}

// Search function
function search(query, category) {
    if (!query.trim() && !category) {
        resultsDiv.classList.add('hidden');
        loading.classList.add('hidden');
        return;
    }

    loading.classList.remove('hidden');

    let url = `{{ route("destinations.search") }}?query=${encodeURIComponent(query)}`;
    if (category) url += `&category=${encodeURIComponent(category)}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            loading.classList.add('hidden');
            renderResults(data);
        });
}

searchInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        search(searchInput.value, categoryFilter.value);
    }, 300);
});

categoryFilter.addEventListener('change', () => {
    search(searchInput.value, categoryFilter.value);
});

clearBtn.addEventListener('click', () => {
    searchInput.value = '';
    resultsDiv.classList.add('hidden');
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
        resultsDiv.classList.add('hidden');
    }
});
</script>

</body>
</html>