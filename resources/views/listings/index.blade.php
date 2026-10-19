<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                🏠 Explorer les logements
            </h2>

            <a href="{{ route('recommendations.index') }}"
               class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
                Voir mes recommandations →
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        {{-- ✅ Filters --}}
        <form method="GET" action="{{ route('listings.index') }}"
              class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 grid grid-cols-1 md:grid-cols-6 gap-4">

            {{-- City --}}
            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Ville</label>
                <select name="city"
                        class="w-full mt-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="">Toutes</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type --}}
            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Type</label>
                <select name="type"
                        class="w-full mt-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="">Tous</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" @selected(request('type') == $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Prix min --}}
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Prix Min</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}"
                       class="w-full mt-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                       placeholder="3000">
            </div>

            {{-- Prix max --}}
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Prix Max</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}"
                       class="w-full mt-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                       placeholder="9000">
            </div>

            {{-- Buttons --}}
            <div class="md:col-span-6 flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-semibold transition">
                    Filtrer
                </button>

                <a href="{{ route('listings.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 px-6 py-2 rounded-xl font-semibold transition">
                    Reset
                </a>
            </div>
        </form>

        {{-- ✅ Listings Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($listings as $l)

                @php
                    // ✅ Badge automatique selon prix
                    if ($l['price'] >= 12000) {
                        $badge = ['Premium', 'bg-purple-600'];
                    } elseif ($l['price'] <= 5000) {
                        $badge = ['Bon plan', 'bg-green-600'];
                    } else {
                        $badge = ['Nouveau', 'bg-orange-500'];
                    }
                @endphp

                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl overflow-hidden hover:shadow-xl transition duration-200 group">

                    {{-- ✅ Image --}}
                    <div class="relative">
                        <img src="{{ $l['image_url'] ?? listing_img($l['id']) }}"
                         class="w-full h-52 object-cover"
                         alt="Photo logement"
                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80';">


                        {{-- ✅ Badge Type --}}
                        <span class="absolute top-3 left-3 text-xs font-semibold px-3 py-1 rounded-full
                            bg-white/90 text-gray-800 dark:bg-gray-900/80 dark:text-white shadow">
                            {{ $l['type'] }}
                        </span>

                        {{-- ✅ Badge City --}}
                        <span class="absolute top-3 right-3 text-xs font-semibold px-3 py-1 rounded-full
                            bg-blue-600 text-white shadow">
                            {{ $l['city'] }}
                        </span>

                        {{-- ✅ Badge Premium / Bon plan / Nouveau --}}
                        <span class="absolute bottom-3 left-3 text-xs font-semibold px-3 py-1 rounded-full text-white shadow {{ $badge[1] }}">
                            {{ $badge[0] }}
                        </span>
                    </div>

                    {{-- ✅ Content --}}
                    <div class="p-5 space-y-2">

                        <p class="text-gray-500 dark:text-gray-300 text-sm">
                            📍 {{ $l['neighborhood'] }}
                        </p>

                        <div class="flex items-center justify-between">
                            <p class="text-xl font-bold text-green-600">
                                {{ $l['price'] }} DH
                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                {{ $l['area'] }} m² • {{ $l['rooms'] }} pièces
                            </p>
                        </div>

                        <div class="flex justify-between items-center pt-3">
                            <a href="{{ route('listings.show', $l['id']) }}"
                               class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-sm">
                                Voir détails →
                            </a>

                            {{-- ⭐ Favori --}}
                            <form method="POST" action="{{ route('favorites.store', $l['id']) }}">
                                @csrf
                                <button type="submit"
                                        class="text-yellow-500 hover:text-yellow-600 text-lg transition"
                                        title="Ajouter aux favoris">
                                    ⭐
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-300 col-span-3 text-center py-10">
                    Aucun logement trouvé.
                </p>
            @endforelse

        </div>

    </div>
</x-app-layout>
