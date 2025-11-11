<nav class="w-full fixed top-0 bg-[#00000010] backdrop-blur-lg z-10">
    <div class="container max-w-[1130px] mx-auto flex items-center justify-between h-[74px] px-4 md:px-6">
        <!-- Logo -->
        <div class="flex items-center gap-4 md:gap-[26px]">
            <a href="{{ route('front.index') }}" class="flex w-[100px] md:w-[154px] shrink-0 items-center">
                <img src="{{ asset('images/logos/WhatsApp Image 2025-09-06 at 10.32.48.svg') }}" alt="logo"
                    class="w-8 md:w-12 border rounded-full">
            </a>

            <!-- Desktop Menu -->
            <ul class="hidden lg:flex gap-6 items-center">
                <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                    <a href="{{ route('front.index') }}">Home</a>
                </li>
                <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 relative">
                    <button id="menu-button" class="flex items-center gap-1 focus:text-belibang-light-grey">
                        <span>Categories</span>
                        <img src="{{ asset('images/icons/arrow-down.svg') }}" alt="icon">
                    </button>
                    <div
                        class="dropdown-menu hidden absolute top-[52px] grid grid-cols-2 p-4 gap-[10px] w-[526px] rounded-[20px] bg-[#510825] border border-[#414141] z-10">
                        <div
                            class="col-span-2 flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('front.category', 0) }}"
                                    class="w-[50px] h-[58px] flex shrink-0 flex items-center">
                                    <img src="{{ asset('images/trolley.png') }}" alt="icon">
                                </a>
                                <a href="{{ route('front.category', 0) }}" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Semua Produk</p>
                                </a>
                            </div>
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{ asset('images/icons/crown.svg') }}" alt="icon">
                            </div>
                        </div>
                        <div
                            class="flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('front.category', 1) }}"
                                    class="w-[40px] h-[40px] flex shrink-0 flex items-center">
                                    <img src="{{ asset('images/pillow.png') }}" alt="icon">
                                </a>
                                <a href="{{ route('front.category', 1) }}" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Bantal</p>
                                </a>
                            </div>
                        </div>
                        <div
                            class="flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('front.category', 2) }}"
                                    class="w-[40px] h-[40px] flex shrink-0 flex items-center">
                                    <img src="{{ asset('images/double-bed.png') }}" alt="icon">
                                </a>
                                <a href="{{ route('front.category', 2) }}" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Seprai</p>
                                </a>
                            </div>
                        </div>
                        <div
                            class="flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('front.category', 3) }}"
                                    class="w-[40px] h-[40px] flex shrink-0 flex items-center">
                                    <img src="{{ asset('images/other.png') }}" alt="icon">
                                </a>
                                <a href="{{ route('front.category', 3) }}" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Lainnya</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Desktop Auth Buttons & Cart -->
        <div class="hidden md:flex gap-4 md:gap-6 items-center">
            <!-- Shopping Cart Button -->
            <button id="cart-button" class="relative text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                @php
                    $cartCount = is_array(session('cart')) ? array_sum(array_column(session('cart'), 'quantity')) : 0;
                @endphp
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
            </button>

            @guest
                <a href="{{ route('login') }}"
                    class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 text-sm md:text-base">Masuk</a>
                <a href="{{ route('register') }}"
                    class="p-[6px_12px] md:p-[8px_16px] w-fit h-fit rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300 text-sm md:text-base">Daftar</a>
            @endguest

            @auth
                <a href="{{ route('admin.dashboard') }}"
                    class="p-[6px_12px] md:p-[8px_16px] w-fit h-fit rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300 text-sm md:text-base">My
                    Dashboard</a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden flex flex-col gap-1 p-2 focus:outline-none">
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
        </button>
    </div>

    <!-- Shopping Cart Dropdown -->
    <div id="cart-dropdown" class="hidden absolute right-4 top-[80px] w-[380px] max-w-[90vw] bg-[#1E1E1E] border border-[#414141] rounded-[20px] shadow-2xl z-20">
        <div class="p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white font-bold text-lg">Keranjang Belanja</h3>
                <button id="close-cart" class="text-belibang-grey hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Cart Items Container -->
            <div id="cart-items" class="space-y-3 max-h-[400px] overflow-y-auto mb-4">
                @if(session('cart') && count(session('cart')) > 0)
                    @foreach(session('cart') as $id => $item)
                        <div class="flex items-center gap-3 p-3 bg-[#2A2A2A] rounded-xl cart-item" data-id="{{ $id }}">
                            <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="text-white font-semibold text-sm mb-1">{{ $item['name'] }}</h4>
                                <p class="text-belibang-grey text-xs">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <button onclick="updateCartQuantity({{ $id }}, -1)" class="w-6 h-6 bg-[#414141] hover:bg-[#510825] text-white rounded flex items-center justify-center transition-all">
                                        -
                                    </button>
                                    <span class="text-white text-sm w-6 text-center quantity-display">{{ $item['quantity'] }}</span>
                                    <button onclick="updateCartQuantity({{ $id }}, 1)" class="w-6 h-6 bg-[#414141] hover:bg-[#510825] text-white rounded flex items-center justify-center transition-all">
                                        +
                                    </button>
                                </div>
                            </div>
                            <button onclick="removeCartItem({{ $id }})" class="text-red-500 hover:text-red-400 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div id="empty-cart" class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-belibang-grey mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-belibang-grey">Keranjang Anda masih kosong</p>
                    </div>
                @endif
            </div>

            <!-- Cart Summary -->
            @if(session('cart') && count(session('cart')) > 0)
                @php
                    $total = collect(session('cart'))->sum(function($item) {
                        return $item['price'] * $item['quantity'];
                    });
                @endphp
                <div id="cart-summary" class="border-t border-[#414141] pt-4">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-belibang-grey">Total:</span>
                        <span id="cart-total" class="text-white font-bold text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('front.checkout') }}" class="block w-full bg-[#510825] hover:bg-[#6B0A32] text-white font-bold py-3 rounded-xl transition-all duration-300 text-center">
                        Checkout
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden bg-[#1E1E1E] border-t border-[#414141]">
        <div class="container max-w-[1130px] mx-auto px-4 py-4">
            <!-- Mobile Cart Button -->
            <button id="mobile-cart-button" class="flex items-center justify-between w-full text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 py-2 mb-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Keranjang</span>
                </div>
                <span id="mobile-cart-count" class="bg-red-600 text-white text-xs font-bold rounded-full px-2 py-1 {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
            </button>

            <!-- Mobile Navigation Links -->
            <div class="space-y-4 mb-6">
                <a href="{{ route('front.index') }}"
                    class="block text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 py-2">Home</a>

                <!-- Mobile Categories -->
                <div class="space-y-2">
                    <button id="mobile-categories-btn"
                        class="flex items-center justify-between w-full text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 py-2">
                        <span>Categories</span>
                        <img src="{{ asset('images/icons/arrow-down.svg') }}" alt="icon"
                            class="transform transition-transform duration-300">
                    </button>

                    <div id="mobile-categories" class="hidden space-y-2 pl-4">
                        <a href="{{ route('front.category', 0) }}"
                            class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{ asset('images/trolley.png') }}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Semua Produk</span>
                        </a>
                        <a href="{{ route('front.category', 1) }}"
                            class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{ asset('images/pillow.png') }}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Bantal</span>
                        </a>
                        <a href="{{ route('front.category', 2) }}"
                            class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{ asset('images/double-bed.png') }}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Seprai</span>
                        </a>
                        <a href="{{ route('front.category', 3) }}"
                            class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{ asset('images/other.png') }}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Lainnya</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile Auth Buttons -->
            <div class="space-y-3 pt-4 border-t border-[#414141]">
                @guest
                    <a href="{{ route('login') }}"
                        class="block text-center py-3 text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="block text-center p-3 rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">Daftar</a>
                @endguest

                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="block text-center p-3 rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">My
                        Dashboard</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Cart dropdown toggle
    const cartButton = document.getElementById('cart-button');
    const mobileCartButton = document.getElementById('mobile-cart-button');
    const cartDropdown = document.getElementById('cart-dropdown');
    const closeCart = document.getElementById('close-cart');

    cartButton.addEventListener('click', function() {
        cartDropdown.classList.toggle('hidden');
    });

    mobileCartButton.addEventListener('click', function() {
        cartDropdown.classList.toggle('hidden');
    });

    closeCart.addEventListener('click', function() {
        cartDropdown.classList.add('hidden');
    });

    // Close cart dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!cartButton.contains(e.target) && !mobileCartButton.contains(e.target) && !cartDropdown.contains(e.target)) {
            cartDropdown.classList.add('hidden');
        }
    });

    // Update cart quantity via AJAX
    function updateCartQuantity(productId, change) {
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                change: change
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to update cart display
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Remove item from cart via AJAX
    function removeCartItem(productId) {
        if (confirm('Hapus produk dari keranjang?')) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to update cart display
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    // Add to cart function (call this from product pages)
    function addToCart(productId) {
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show notification
                alert('Produk berhasil ditambahkan ke keranjang!');
                location.reload(); // Reload to update cart count
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Category dropdown functionality
    const menuButton = document.getElementById('menu-button');
    const dropdown = document.querySelector('.dropdown-menu');

    menuButton.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!menuButton.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Mobile menu functionality
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const spans = this.querySelectorAll('span');

        mobileMenu.classList.toggle('hidden');

        // Animate hamburger to X
        if (!mobileMenu.classList.contains('hidden')) {
            spans[0].style.transform = 'rotate(45deg) translateY(6px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translateY(-6px)';
        } else {
            spans[0].style.transform = 'none';
            spans[1].style.opacity = '1';
            spans[2].style.transform = 'none';
        }
    });

    // Mobile categories dropdown
    document.getElementById('mobile-categories-btn').addEventListener('click', function() {
        const mobileCategories = document.getElementById('mobile-categories');
        const arrow = this.querySelector('img');

        mobileCategories.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    });

    // Close mobile menu when window is resized to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburger = document.getElementById('mobile-menu-btn');
            const spans = hamburger.querySelectorAll('span');

            mobileMenu.classList.add('hidden');
            spans[0].style.transform = 'none';
            spans[1].style.opacity = '1';
            spans[2].style.transform = 'none';
        }
    });
</script>