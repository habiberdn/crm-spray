<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo/Brand (optional - tambahkan jika diperlukan) -->
                <div class="flex-shrink-0 mr-4">
                    <!-- Tempat untuk logo -->
                </div>
                
                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex md:items-center md:space-x-6">
                    <x-nav-link :href="route('front.index')" :active="request()->routeIs('home')" 
                                class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                        {{ __('Beranda') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('dashboard')"
                                class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if (auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')"
                                    class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ __('Produk') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.product_orders.index')" :active="request()->routeIs('admin.product_orders.index')"
                                    class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ __('Pesanan') }}
                        </x-nav-link>
                        
                        <!-- Perbaiki route untuk Diskon - sementara menggunakan route yang sama -->
                        <x-nav-link :href="route('admin.diskon.index')" :active="request()->routeIs('admin.diskon.index')"
                                    class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ __('Diskon') }}
                        </x-nav-link>
                    @endif
                    
                    @if (auth()->user()->role === 'buyer')
                        <x-nav-link :href="route('admin.product_orders.transactions')" :active="request()->routeIs('admin.product_orders.transactions')"
                                    class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium transition-colors duration-200">
                            {{ __('Transaksi Saya') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Desktop User Dropdown -->
            <div class="hidden md:flex md:items-center md:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            <img src="{{ Storage::url(Auth::user()->avatar) }}"
                                class="mr-2 w-8 h-8 rounded-full object-cover border border-gray-200" 
                                alt="{{ Auth::user()->name }}">
                            
                            <span class="hidden lg:block max-w-xs truncate">{{ Auth::user()->name }}</span>

                            <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition duration-150 ease-in-out"
                    :aria-expanded="open"
                    aria-label="Toggle navigation menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" 
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" 
         class="hidden md:hidden border-t border-gray-200 bg-white"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        
        <!-- Mobile Navigation Links -->
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('front.index')" :active="request()->routeIs('home')"
                                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('dashboard')"
                                   class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if (auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')"
                                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    {{ __('Produk') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.product_orders.index')" :active="request()->routeIs('admin.product_orders.index')"
                                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    {{ __('Pesanan') }}
                </x-responsive-nav-link>
                
             
            @endif
            
            @if (auth()->user()->role === 'buyer')
                <x-responsive-nav-link :href="route('admin.product_orders.transactions')" :active="request()->routeIs('admin.product_orders.transactions')"
                                       class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    {{ __('Transaksi Saya') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Mobile User Info & Settings -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4 mb-3">
                <img src="{{ Storage::url(Auth::user()->avatar) }}"
                     class="h-10 w-10 rounded-full object-cover border border-gray-200" 
                     alt="{{ Auth::user()->name }}">
                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="px-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                                       class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>