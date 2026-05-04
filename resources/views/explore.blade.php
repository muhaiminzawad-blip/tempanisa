<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explore Nearby Places</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        .map-card { min-height: 520px; }
        .place-card { transition: transform .2s ease, box-shadow .2s ease; }
        .place-card:hover { transform: translateY(-2px); box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12); }
        /* Fix for default markers */
        .leaflet-default-icon-path {
            background-image: url('https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png');
        }
    </style>
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

            <!-- ✅ Only Get Started Button remains -->
            <div class="hidden md:flex space-x-4">
                <a href="{{ route('login') }}" class="px-5 py-2 text-white bg-blue-600 rounded-full">
                    Get Started
                </a>
            </div>

            <button class="md:hidden text-2xl">☰</button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 pt-24">
        <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
            <section class="bg-white/55 backdrop-blur-3xl border border-white/70 rounded-3xl shadow-2xl p-6">
                <h1 class="text-4xl font-bold text-slate-900">Explore Nearby Places</h1>
                <p class="mt-3 text-slate-600">Search for restaurants, parks, hills, beaches or any place near you with Google Maps.</p>

                <div class="mt-8 space-y-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700">Search</label>
                        <div class="flex gap-2">
                            <input id="searchInput" type="text" placeholder="restaurants, park, hill, beach" class="min-w-0 flex-1 rounded-3xl border border-slate-300 bg-white/80 px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent" value="restaurants">
                            <button id="searchBtn" class="rounded-3xl bg-cyan-500 px-5 py-3 text-white font-semibold shadow-lg hover:bg-cyan-600 transition">Search</button>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <button data-query="restaurants" class="explore-chip rounded-3xl bg-white/80 border border-slate-200 px-4 py-3 text-slate-800 font-semibold hover:bg-cyan-50 transition">Restaurants</button>
                        <button data-query="park" class="explore-chip rounded-3xl bg-white/80 border border-slate-200 px-4 py-3 text-slate-800 font-semibold hover:bg-cyan-50 transition">Park</button>
                        <button data-query="beach" class="explore-chip rounded-3xl bg-white/80 border border-slate-200 px-4 py-3 text-slate-800 font-semibold hover:bg-cyan-50 transition">Beach</button>
                        <button data-query="hill" class="explore-chip rounded-3xl bg-white/80 border border-slate-200 px-4 py-3 text-slate-800 font-semibold hover:bg-cyan-50 transition">Hill</button>
                        <button data-query="destination" class="explore-chip rounded-3xl bg-white/80 border border-slate-200 px-4 py-3 text-slate-800 font-semibold hover:bg-cyan-50 transition">Destinations</button>
                    </div>

                    <div class="rounded-3xl bg-slate-900/10 border border-white/60 p-4 text-sm text-slate-600">
                        <p><strong>Tip:</strong> This map shows popular places in Cox's Bazar. Allow location access to center the map on your current position. Use the search and category buttons to explore different types of attractions.</p>
                    </div>
                </div>
            </section>

            <section class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
                    <div class="map-card rounded-3xl overflow-hidden border border-white/70 shadow-2xl bg-white/60">
                        <div id="map" class="w-full h-[520px]"></div>
                    </div>
                    <div class="rounded-3xl bg-white/55 backdrop-blur-3xl border border-white/70 shadow-2xl p-6 h-[520px] overflow-hidden">
                        <h2 class="text-xl font-semibold text-slate-900">Search Results</h2>
                        <div id="placesList" class="mt-5 space-y-4 overflow-y-auto h-[440px] pr-2"></div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        // Cox's Bazar coordinates
        const coxsBazarCenter = [21.4272, 92.0058];

        // Destinations from database
        const destinations = @json($destinations);

        // Predefined popular places in Cox's Bazar
        const places = [
            {
                name: "Cox's Bazar Beach",
                coords: [21.4272, 92.0058],
                description: "World's longest natural sea beach stretching 120km",
                type: "beach",
                rating: 4.5
            },
            {
                name: "Himchari National Park",
                coords: [21.3667, 92.0167],
                description: "Beautiful waterfall and picnic spot",
                type: "park",
                rating: 4.2
            },
            {
                name: "Inani Beach",
                coords: [21.3833, 92.0833],
                description: "Peaceful beach with coral reefs",
                type: "beach",
                rating: 4.3
            },
            {
                name: "Laboni Beach",
                coords: [21.4167, 91.9833],
                description: "Secluded beach perfect for relaxation",
                type: "beach",
                rating: 4.1
            },
            {
                name: "Marine Drive",
                coords: [21.4272, 92.0058],
                description: "Scenic road along the beach",
                type: "attraction",
                rating: 4.4
            },
            {
                name: "Sugandha Beach",
                coords: [21.4333, 91.9833],
                description: "Beautiful beach with clear water",
                type: "beach",
                rating: 4.0
            },
            {
                name: "Kolatoli Beach",
                coords: [21.4272, 92.0058],
                description: "Popular beach area with resorts",
                type: "beach",
                rating: 4.2
            },
            {
                name: "Sea Food Market",
                coords: [21.4272, 92.0058],
                description: "Fresh seafood and local delicacies",
                type: "restaurant",
                rating: 4.1
            }
        ];

        // Map destination categories to place types
        const categoryTypeMap = {
            'beach': 'beach',
            'hill': 'hill',
            'park': 'park',
            'restaurant': 'restaurants',
            'hotels': 'restaurant'
        };

        // Add destinations to places with proper category mapping
        destinations.forEach(dest => {
            // Map destination categories to our filter types
            let type = 'destination';
            const category = dest.category ? dest.category.toLowerCase() : '';
            
            if (category.includes('beach') || category.includes('island')) {
                type = 'beach';
            } else if (category.includes('hill') || category.includes('mountain') || category.includes('nature')) {
                type = 'hill';
            } else if (category.includes('waterfall')) {
                type = 'park';
            } else if (category.includes('cultural') || category.includes('monastery') || category.includes('temple')) {
                type = 'destination';
            } else if (category.includes('eco') || category.includes('adventure') || category.includes('wildlife')) {
                type = 'destination';
            }
            
            // Use Cox's Bazar center as placeholder since DB doesn't have coords
            const coords = [21.4272 + (Math.random() - 0.5) * 0.1, 92.0058 + (Math.random() - 0.5) * 0.1];
            
            places.push({
                name: dest.name,
                coords: coords,
                description: dest.description || dest.category || 'Destination',
                type: type,
                rating: dest.rating || 4.0
            });
        });

        let map, markers = [], userLocation = null, routingControl = null;

        function initMap() {
            // Initialize map centered on Cox's Bazar
            map = L.map('map').setView(coxsBazarCenter, 12);

            // Add OpenStreetMap tiles (free, no API key required)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            // Try to get user location and center map there
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    userLocation = [position.coords.latitude, position.coords.longitude];
                    map.setView(userLocation, 14);
                    // Add a marker for user's location
                    L.marker(userLocation)
                        .addTo(map)
                        .bindPopup('Your Location')
                        .openPopup();
                }, () => {
                    // If geolocation fails, show Cox's Bazar places
                    showPlaces('beach');
                });
            } else {
                showPlaces('beach');
            }

            // Default to showing beaches
            showPlaces('beach');
        }

        function clearMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
        }

        function setActiveChip(query) {
            document.querySelectorAll('.explore-chip').forEach(btn => {
                btn.classList.toggle('bg-cyan-100', btn.dataset.query === query);
                btn.classList.toggle('border-cyan-300', btn.dataset.query === query);
            });
        }

        function showPlaces(type) {
            clearMarkers();
            setActiveChip(type);

            let filteredPlaces = [];
            
            // Special handling for predefined categories vs database destinations
            if (type === 'restaurants') {
                filteredPlaces = places.filter(place => place.type === 'restaurants' || place.type === 'restaurant');
            } else if (type === 'beach') {
                filteredPlaces = places.filter(place => place.type.toLowerCase().includes('beach'));
            } else if (type === 'hill') {
                filteredPlaces = places.filter(place => 
                    place.type.toLowerCase().includes('hill') || 
                    place.type.toLowerCase().includes('mountain') || 
                    place.type.toLowerCase().includes('nature')
                );
            } else if (type === 'park') {
                filteredPlaces = places.filter(place => place.type.toLowerCase().includes('park'));
            } else if (type === 'destination') {
                // Show all that are destinations or have meaningful locations
                filteredPlaces = places.filter(place => 
                    place.type === 'destination' || 
                    place.type.toLowerCase().includes('waterfall') ||
                    place.type.toLowerCase().includes('cultural') ||
                    place.type.toLowerCase().includes('eco') ||
                    place.type.toLowerCase().includes('island')
                );
            } else {
                filteredPlaces = places.filter(place => place.type === type);
            }
            
            const list = document.getElementById('placesList');
            list.innerHTML = '';

            if (filteredPlaces.length === 0) {
                list.innerHTML = '<p class="text-slate-500">No places found for this category.</p>';
                return;
            }

            filteredPlaces.forEach((place, index) => {
                // Add marker to map
                const marker = L.marker(place.coords)
                    .addTo(map)
                    .bindPopup(`<div><strong>${place.name}</strong><br>${place.description}<br><button onclick="getDirections(${place.coords[0]}, ${place.coords[1]})" class="mt-2 px-2 py-1 bg-blue-500 text-white rounded">Get Directions</button></div>`);

                markers.push(marker);

                // Add to results list
                const card = document.createElement('div');
                card.className = 'place-card rounded-3xl border border-slate-200/70 bg-white/90 p-4 shadow-sm hover:shadow-lg cursor-pointer';
                card.innerHTML = `
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-lg font-semibold text-slate-900">${index + 1}. ${place.name}</p>
                            <p class="text-sm text-slate-600 mt-1">${place.description}</p>
                        </div>
                        <span class="inline-flex rounded-full bg-cyan-100 px-3 py-1 text-xs font-semibold text-cyan-700">${place.rating}</span>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <button class="rounded-lg bg-blue-500 px-3 py-1 text-xs text-white hover:bg-blue-600" onclick="getDirections(${place.coords[0]}, ${place.coords[1]})">Get Directions</button>
                        <p class="text-sm text-slate-500">${place.type}</p>
                    </div>
                `;

                card.addEventListener('click', () => {
                    map.setView(place.coords, 15);
                    marker.openPopup();
                });

                list.appendChild(card);
            });

            // Fit map to show all markers
            if (filteredPlaces.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        function getDirections(lat, lng) {
            if (!userLocation) {
                alert('Please allow location access to get directions.');
                return;
            }

            // Remove existing routing control
            if (routingControl) {
                map.removeControl(routingControl);
            }

            // Add routing control
            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(userLocation[0], userLocation[1]),
                    L.latLng(lat, lng)
                ],
                routeWhileDragging: true,
                createMarker: function() { return null; } // Don't create default markers
            }).addTo(map);
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', initMap);

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', () => {
            const query = document.getElementById('searchInput').value.trim().toLowerCase();
            if (query.includes('restaurant') || query.includes('food') || query.includes('restaurants')) {
                showPlaces('restaurants');
            } else if (query.includes('park') || query.includes('waterfall')) {
                showPlaces('park');
            } else if (query.includes('beach')) {
                showPlaces('beach');
            } else if (query.includes('hill')) {
                showPlaces('hill');
            } else if (query.includes('destination')) {
                showPlaces('restaurant');
            } else {
                // Default to beach if no match
                showPlaces('beach');
            }
        });

        // Chip button functionality
        document.querySelectorAll('.explore-chip').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('searchInput').value = button.dataset.query;
                showPlaces(button.dataset.query);
            });
        });
    </script>
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine JavaScript -->
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
</body>
</html>