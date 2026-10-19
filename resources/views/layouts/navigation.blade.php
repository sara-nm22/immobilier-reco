<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- ✅ LEFT -->
            <div class="flex items-center gap-10">
                
                <!-- ✅ Logo + Name -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 flex items-center justify-center bg-blue-600 text-white rounded-xl font-bold shadow">
                        R
                    </div>
                    <span class="font-bold text-gray-800 dark:text-gray-200 text-lg tracking-wide">
                        RecoHousing
                    </span>
                </a>

                <!-- ✅ Navigation Links -->
                <div class="hidden sm:flex items-center gap-6">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        🏠 Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.*')">
                        📋 Logements
                    </x-nav-link>

                    <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.*')">
                        ⭐ Favoris
                    </x-nav-link>

                    <x-nav-link :href="route('history.index')" :active="request()->routeIs('history.*')">
                        👀 Historique
                    </x-nav-link>

                    <x-nav-link :href="route('recommendations.index')" :active="request()->routeIs('recommendations.*')">
                        🎯 Recommandations
                    </x-nav-link>
                </div>

            </div>

            <!-- ✅ RIGHT (Profile dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition">
                            <span class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded-lg">
                                {{ Auth::user()->name }}
                            </span>

                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            👤 Profil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- ✅ Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- ✅ Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 dark:border-gray-700">
        <div class="pt-3 pb-3 space-y-1 px-4">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🏠 Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.*')">
                📋 Logements
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.*')">
                ⭐ Favoris
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('history.index')" :active="request()->routeIs('history.*')">
                👀 Historique
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('recommendations.index')" :active="request()->routeIs('recommendations.*')">
                🎯 Recommandations
            </x-responsive-nav-link>

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700 px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    👤 Profil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        🚪 Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
