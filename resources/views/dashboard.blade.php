<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                👋 Bonjour {{ Auth::user()->name }}
            </h2>

            <a href="{{ route('listings.index') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-semibold transition">
                Explorer les logements →
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-8">

        {{-- ✅ Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <p class="text-sm text-gray-500 dark:text-gray-300">Logements consultés</p>
                <p class="text-4xl font-bold text-blue-600 mt-2">{{ $stats['viewed'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Historique des visites</p>

                <a href="{{ route('history.index') }}"
                   class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:underline mt-4 block">
                    Voir historique →
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <p class="text-sm text-gray-500 dark:text-gray-300">Favoris enregistrés</p>
                <p class="text-4xl font-bold text-yellow-500 mt-2">{{ $stats['favorites'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Logements que tu as aimés</p>

                <a href="{{ route('favorites.index') }}"
                   class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:underline mt-4 block">
                    Voir favoris →
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <p class="text-sm text-gray-500 dark:text-gray-300">Recommandations</p>
                <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['recos'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Basées sur ton comportement</p>

                <a href="{{ route('recommendations.index') }}"
                   class="text-blue-600 dark:text-blue-400 font-semibold text-sm hover:underline mt-4 block">
                    Voir recommandations →
                </a>
            </div>

        </div>

        {{-- ✅ Quick Actions --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    ⚡ Actions rapides
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-300">
                    Accède rapidement aux fonctionnalités principales.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('listings.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-semibold transition">
                    🏡 Logements
                </a>

                <a href="{{ route('favorites.index') }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-xl font-semibold transition">
                    ⭐ Favoris
                </a>

                <a href="{{ route('history.index') }}"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2 rounded-xl font-semibold transition">
                    👓 Historique
                </a>

                <a href="{{ route('recommendations.index') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl font-semibold transition">
                    🎯 Recos
                </a>
            </div>
        </div>

        {{-- ✅ Recommendations Section --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 space-y-4">

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    🎯 Recommandations pour toi
                </h3>

                <a href="{{ route('recommendations.index') }}"
                   class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
                    Voir tout →
                </a>
            </div>

            {{-- ✅ Mode --}}
            @if($mode == "collab")
                <p class="text-sm text-green-600 font-semibold">
                    ✅ Basées sur utilisateurs similaires (favoris)
                </p>
            @elseif($mode == "content")
                <p class="text-sm text-blue-600 font-semibold">
                    ✅ Basées sur tes préférences (ville/type/budget)
                </p>
            @elseif($mode == "viewed")
                <p class="text-sm text-purple-600 font-semibold">
                    ✅ Basées sur ton historique (VIEWED)
                </p>
            @endif

            {{-- ✅ Top recos cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @forelse($topRecs as $rec)

                    @php
                        $l = $rec['listing'];
                        $img = $l['image_url'] ?? listing_img(
                            $l['id'],
                            $l['type'] ?? null,
                            $l['city'] ?? null,
                            $l['neighborhood'] ?? null
                        );
                    @endphp

                    <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl overflow-hidden shadow hover:shadow-lg transition">

                        <img src="{{ $img }}"
                             class="w-full h-36 object-cover"
                             alt="photo"
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80';">

                        <div class="p-4 space-y-1">
                            <h4 class="font-bold text-gray-800 dark:text-gray-100">
                                {{ $l['type'] }} - {{ $l['city'] }}
                            </h4>

                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                📍 {{ $l['neighborhood'] }}
                            </p>

                            <div class="flex items-center justify-between pt-2">
                                <p class="font-bold text-green-600 text-lg">
                                    {{ $l['price'] }} DH
                                </p>

                                <a href="{{ route('listings.show', $l['id']) }}"
                                   class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
                                    Voir →
                                </a>
                            </div>
                        </div>

                    </div>

                @empty
                    <p class="text-gray-500 dark:text-gray-300 col-span-3 text-center py-6">
                        Aucune recommandation disponible. Ajoute des favoris ou consulte des logements.
                    </p>
                @endforelse

            </div>

        </div>

    </div>
</x-app-layout>
