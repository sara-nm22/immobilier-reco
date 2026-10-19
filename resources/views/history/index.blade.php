<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                👀 Historique des visites
            </h2>

            <a href="{{ route('listings.index') }}"
               class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
                ← Retour aux logements
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        @forelse($history as $h)
            @php
                $l = $h['listing'];
            @endphp

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-5 flex flex-col md:flex-row gap-6 items-center justify-between">

                <!-- ✅ left: image + info -->
                <div class="flex gap-4 items-center w-full">
                    <img src="{{ listing_img($l['id']) }}"
                         class="w-40 h-28 rounded-xl object-cover shadow"
                         alt="photo">

                    <div class="space-y-1">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">
                            {{ $l['type'] }} - {{ $l['city'] }}
                        </h3>

                        <p class="text-gray-500 dark:text-gray-300 text-sm">
                            📍 {{ $l['neighborhood'] }} • 🛏 {{ $l['rooms'] }} • 📐 {{ $l['area'] }} m²
                        </p>

                        <p class="text-green-600 font-bold text-lg">
                            {{ $l['price'] }} DH
                        </p>

                        <p class="text-xs text-gray-400">
                            Vu le : {{ $h['ts'] }}
                        </p>
                    </div>
                </div>

                <!-- ✅ right actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('listings.show', $l['id']) }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold transition">
                        Voir
                    </a>
                </div>

            </div>

        @empty
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-10 text-center">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-100">
                    Aucun historique pour le moment
                </h3>
                <p class="text-gray-500 dark:text-gray-300 mt-2">
                    Consulte des logements pour que ton historique se remplisse ✅
                </p>

                <a href="{{ route('listings.index') }}"
                   class="inline-block mt-5 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                    Explorer les logements →
                </a>
            </div>
        @endforelse

    </div>
</x-app-layout>
