<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                🏡 Détails du logement
            </h2>

            <a href="{{ route('listings.index') }}"
               class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
                ← Retour aux logements
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-10">

        {{-- ✅ Card principale --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl overflow-hidden">

            {{-- ✅ Carousel images --}}
            @php
                $id = $listing['id'];
                $seed = (int) preg_replace('/\D/', '', $id);

                $imgs = [
                    "https://source.unsplash.com/1200x600/?house,interior&sig=".($seed+1),
                    "https://source.unsplash.com/1200x600/?apartment,living-room&sig=".($seed+2),
                    "https://source.unsplash.com/1200x600/?home,bedroom&sig=".($seed+3),
                ];
            @endphp

            <div class="relative w-full h-72 overflow-hidden">
                <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
                    @foreach($imgs as $img)
                        <img src="{{ $img }}"
                             class="w-full h-72 object-cover flex-shrink-0"
                             alt="image logement"
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80';">
                    @endforeach
                </div>

                {{-- ✅ dots --}}
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                    <span class="dot w-3 h-3 bg-white/70 rounded-full"></span>
                    <span class="dot w-3 h-3 bg-white/40 rounded-full"></span>
                    <span class="dot w-3 h-3 bg-white/40 rounded-full"></span>
                </div>
            </div>

            {{-- ✅ Infos --}}
            <div class="p-8 space-y-6">

                <div class="flex justify-between items-start flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $listing['type'] }} - {{ $listing['city'] }}
                        </h1>

                        <p class="text-gray-500 dark:text-gray-300 mt-1">
                            📍 {{ $listing['neighborhood'] }}
                        </p>
                    </div>

                    <p class="text-2xl font-bold text-green-600">
                        {{ $listing['price'] }} DH
                    </p>
                </div>

                {{-- ✅ Détails --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 text-center">
                        <p class="text-gray-500 text-sm">Surface</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            {{ $listing['area'] }} m²
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 text-center">
                        <p class="text-gray-500 text-sm">Pièces</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            {{ $listing['rooms'] }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 text-center">
                        <p class="text-gray-500 text-sm">Ville</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            {{ $listing['city'] }}
                        </p>
                    </div>
                </div>

                {{-- ✅ Favori --}}
                <form method="POST" action="{{ route('favorites.store', $listing['id']) }}">
                    @csrf
                    <button type="submit"
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold transition">
                        ⭐ Ajouter aux favoris
                    </button>
                </form>

            </div>
        </div>


        {{-- ✅ Carte --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 space-y-4">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                🗺 Localisation
            </h2>

            <div id="map" class="w-full h-72 rounded-xl"></div>
        </div>


        {{-- ✅ Logements similaires --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                    🔥 Logements similaires
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($similar as $s)

                    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl overflow-hidden hover:shadow-xl transition">

                        <img src="{{ listing_img($s['id'], $s['type'], $s['city'], $s['neighborhood']) }}"
                             class="w-full h-40 object-cover"
                             alt="image logement"
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80';">

                        <div class="p-4 space-y-2">
                            <h3 class="font-bold text-gray-800 dark:text-white">
                                {{ $s['type'] }} - {{ $s['city'] }}
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                📍 {{ $s['neighborhood'] }}
                            </p>

                            <div class="flex justify-between items-center pt-2">
                                <p class="font-bold text-green-600 text-lg">
                                    {{ $s['price'] }} DH
                                </p>

                                <a href="{{ route('listings.show', $s['id']) }}"
                                   class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-sm">
                                    Voir →
                                </a>
                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-gray-500 dark:text-gray-300 col-span-3 text-center py-8">
                        Aucun logement similaire trouvé.
                    </p>
                @endforelse

            </div>
        </div>

    </div>


    {{-- ✅ JS Carousel + Map --}}
    <script>
        // ✅ Carousel
        let index = 0;
        const carousel = document.getElementById("carousel");
        const dots = document.querySelectorAll(".dot");

        setInterval(() => {
            index = (index + 1) % 3;
            carousel.style.transform = `translateX(-${index * 100}%)`;

            dots.forEach((d, i) => {
                d.classList.remove("bg-white/70");
                d.classList.add("bg-white/40");
                if (i === index) {
                    d.classList.add("bg-white/70");
                    d.classList.remove("bg-white/40");
                }
            });

        }, 3000);


        // ✅ Map Leaflet
        const coords = {
            "Casablanca": [33.5731, -7.5898],
            "Rabat": [34.0209, -6.8416],
            "Marrakech": [31.6295, -7.9811],
            "Fès": [34.0331, -5.0003],
            "Tanger": [35.7595, -5.8340],
            "Agadir": [30.4278, -9.5981]
        };

        let city = "{{ $listing['city'] }}";
        let position = coords[city] ?? [33.5731, -7.5898];

        const map = L.map('map').setView(position, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18
        }).addTo(map);

        L.marker(position).addTo(map)
            .bindPopup("📍 {{ $listing['city'] }} - {{ $listing['neighborhood'] }}")
            .openPopup();
    </script>

</x-app-layout>
