<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                🎯 Recommandations
            </h2>

            <a href="{{ route('listings.index') }}"
               class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
                Explorer les logements →
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        {{-- ✅ Intro --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 space-y-2">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                ✨ Sélection personnalisée
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-300">
                Ces recommandations sont générées automatiquement selon tes interactions.
            </p>

            {{-- ✅ Mode affiché --}}
            @if($mode == "collab")
                <p class="text-sm text-green-600 font-semibold">
                    ✅ Basées sur utilisateurs similaires
                </p>
            @elseif($mode == "content")
                <p class="text-sm text-blue-600 font-semibold">
                    ✅ Basées sur tes préférences (ville / type / budget)
                </p>
            @elseif($mode == "fallback")
                <p class="text-sm text-gray-500 font-semibold">
                    ✅ Suggestions générales (fallback)
                </p>
            @endif
        </div>

        {{-- ✅ Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($recommendations as $rec)

                @php
                    $l = $rec['listing'];
                    $score = $rec['score'];
                    $img = $l['image_url'] ?? listing_img($l['id'], $l['type'], $l['city'], $l['neighborhood']);
                @endphp

                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl overflow-hidden hover:shadow-xl transition group">

                    {{-- ✅ Image --}}
                    <div class="relative">
                        <img src="{{ $img }}"
                             class="w-full h-44 object-cover"
                             alt="Photo logement"
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80';"
                        >

                        {{-- Score badge --}}
                        <span class="absolute top-3 right-3 text-xs font-semibold px-3 py-1 rounded-full
                            bg-green-600 text-white shadow">
                            Score {{ $score }}
                        </span>

                        {{-- Type badge --}}
                        <span class="absolute top-3 left-3 text-xs font-semibold px-3 py-1 rounded-full
                            bg-white/90 text-gray-800 dark:bg-gray-900/80 dark:text-white shadow">
                            {{ $l['type'] }}
                        </span>
                    </div>

                    {{-- ✅ Content --}}
                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg">
                            {{ $l['type'] }} - {{ $l['city'] }}
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            📍 {{ $l['neighborhood'] }}
                        </p>

                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            🛏 {{ $l['rooms'] }} • 📐 {{ $l['area'] }} m²
                        </p>

                        <div class="flex items-center justify-between pt-3">
                            <p class="text-xl font-bold text-green-600">
                                {{ $l['price'] }} DH
                            </p>

                            <a href="{{ route('listings.show', $l['id']) }}"
                               class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-sm">
                                Voir →
                            </a>
                        </div>

                        {{-- ✅ Favori button --}}
                        <form method="POST" action="{{ route('favorites.store', $l['id']) }}" class="pt-3">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-xl font-semibold transition text-sm">
                                ⭐ Ajouter aux favoris
                            </button>
                        </form>
                    </div>

                </div>

            @empty
                <div class="col-span-3 bg-white dark:bg-gray-800 shadow rounded-2xl p-10 text-center">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">
                        Pas encore de recommandations 😅
                    </h3>

                    <p class="text-gray-500 dark:text-gray-300 mt-2">
                        Ajoute des favoris ou consulte des logements pour générer des recommandations.
                    </p>

                    <a href="{{ route('listings.index') }}"
                       class="inline-block mt-5 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                        Explorer les logements →
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
