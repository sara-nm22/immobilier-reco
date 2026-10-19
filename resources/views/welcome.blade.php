<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RecoHousing - Recommandation Immobilière</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
</head>

<body class="antialiased bg-gray-50 text-gray-900">

{{-- ✅ NAVBAR --}}
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold text-lg shadow">
                R
            </div>
            <h1 class="font-bold text-lg tracking-wide">RecoHousing</h1>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold transition shadow">
                    Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="text-gray-700 hover:text-blue-600 font-semibold">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold transition shadow">
                    Register
                </a>
            @endauth
        </div>
    </div>
</header>

{{-- ✅ HERO --}}
<section class="max-w-7xl mx-auto px-6 py-14 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
    <div class="space-y-6">
        <h2 class="text-4xl font-extrabold leading-tight">
            Trouve ton logement idéal avec <span class="text-blue-600">RecoHousing</span>
        </h2>

        <p class="text-gray-600 text-lg leading-relaxed">
            Une plateforme intelligente qui recommande des logements adaptés à ton budget,
            ton historique de navigation et tes favoris grâce à <b>Neo4j</b>.
        </p>

        <div class="flex gap-3 flex-wrap">
            @auth
                <a href="{{ route('listings.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition shadow">
                    Explorer les logements →
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition shadow">
                    Créer un compte →
                </a>
                <a href="{{ route('login') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-xl font-semibold transition">
                    Se connecter
                </a>
            @endauth
        </div>

        {{-- ✅ Features --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6">
            <div class="bg-white shadow rounded-xl p-4">
                <h4 class="font-bold">📌 Recommandations avancées</h4>
                <p class="text-sm text-gray-600 mt-1">Basées sur utilisateurs similaires et favoris.</p>
            </div>
            <div class="bg-white shadow rounded-xl p-4">
                <h4 class="font-bold">⭐ Favoris + Historique</h4>
                <p class="text-sm text-gray-600 mt-1">Tout ton comportement est enregistré sur Neo4j.</p>
            </div>
        </div>
    </div>

    {{-- ✅ Hero Image --}}
    <div class="relative">
        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80"
             class="rounded-3xl shadow-2xl w-full object-cover h-[420px]"
             alt="Hero">
    </div>
</section>

{{-- ✅ LISTINGS (EXEMPLES) --}}
<section class="max-w-7xl mx-auto px-6 pb-20 space-y-8">
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-bold">🏠 Exemples de logements</h3>

        @auth
            <a href="{{ route('listings.index') }}" class="text-blue-600 hover:underline font-semibold">
                Voir plus →
            </a>
        @endauth
    </div>

    @php
        $cards = [
            ['id'=>'L1','type'=>'Appartement','city'=>'Casablanca','neighborhood'=>'Maarif','price'=>7200],
            ['id'=>'L2','type'=>'Villa','city'=>'Marrakech','neighborhood'=>'Guéliz','price'=>14500],
            ['id'=>'L3','type'=>'Studio','city'=>'Rabat','neighborhood'=>'Agdal','price'=>5000],
            ['id'=>'L4','type'=>'Maison','city'=>'Tanger','neighborhood'=>'Centre','price'=>9500],
            ['id'=>'L5','type'=>'Appartement','city'=>'Fès','neighborhood'=>'Ville Nouvelle','price'=>6100],
            ['id'=>'L6','type'=>'Studio','city'=>'Agadir','neighborhood'=>'Marina','price'=>4200],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($cards as $c)
            <div class="bg-white shadow rounded-2xl overflow-hidden hover:shadow-xl transition">

                <img src="{{ listing_img($c['id'], $c['type'], $c['city'], $c['neighborhood']) }}"
                     class="w-full h-48 object-cover"
                     alt="logement">

                <div class="p-5 space-y-2">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-lg">{{ $c['type'] }}</h4>
                        <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">
                            {{ $c['city'] }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-500">📍 {{ $c['neighborhood'] }}</p>

                    <p class="text-green-600 font-bold text-xl mt-3">{{ $c['price'] }} DH</p>

                    @auth
                        <a href="{{ route('listings.index') }}"
                           class="inline-block mt-4 text-blue-600 hover:underline font-semibold">
                            Voir sur la plateforme →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block mt-4 text-blue-600 hover:underline font-semibold">
                            Accéder à la plateforme →
                        </a>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ✅ FOOTER --}}
<footer class="bg-white border-t">
    <div class="max-w-7xl mx-auto px-6 py-6 text-center text-sm text-gray-500">
        © {{ date('Y') }} RecoHousing — Projet Laravel + Neo4j (Recommandation Immobilière)
    </div>
</footer>

</body>
</html>
