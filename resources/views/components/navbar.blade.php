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
                    <button type="button" id="menu-button"
                        class="flex items-center gap-1 focus:text-belibang-light-grey">
                        <span>Categories</span>
                        <img src="{{ asset('images/icons/arrow-down.svg') }}" alt="icon" class="w-4 h-4">
                    </button>
                    <div id="dropdown-menu"
                        class="hidden absolute left-0 top-[52px] grid grid-cols-2 p-4 gap-[10px] w-[526px] rounded-[20px] bg-[#510825] border border-[#414141] z-[9999]">
                        <div
                            class="col-span-2 flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('front.category', 0) }}"
                                    class="w-[50px] h-[58px] flex shrink-0 items-center">
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
                                    class="w-[40px] h-[40px] flex shrink-0 items-center">
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
                                    class="w-[40px] h-[40px] flex shrink-0 items-center">
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
                                    class="w-[40px] h-[40px] flex shrink-0 items-center">
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
            <button type="button" id="cart-button"
                class="relative text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                @php
                    // Hitung cart count dari session
                    $cart = session()->get('cart', []);

                    // Jika user login, sync dengan database
                    if (auth()->check()) {
                        $dbCartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                        $cartCount = $dbCartCount;
                    } else {
                        $cartCount = is_array($cart) ? array_sum(array_column($cart, 'quantity')) : 0;
                    }
                @endphp
                <span id="cart-count"
                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
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
        <button type="button" id="mobile-menu-btn" class="lg:hidden flex flex-col gap-1 p-2 focus:outline-none">
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
        </button>
    </div>

    <!-- Shopping Cart Dropdown -->
    <div id="cart-dropdown"
        class="hidden absolute right-4 top-[80px] w-[380px] max-w-[90vw] bg-[#1E1E1E] border border-[#414141] rounded-[20px] shadow-2xl z-20">
        <div class="p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white font-bold text-lg">Keranjang Belanja</h3>
                <button type="button" id="close-cart" class="text-belibang-grey hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Cart Items Container -->
            <div id="cart-items" class="space-y-3 max-h-[400px] overflow-y-auto mb-4">
                @php
                    // Ambil cart dari database jika user login
                    if (auth()->check()) {
                        $dbCarts = \App\Models\Cart::where('user_id', auth()->id())->get();

                        $cart = [];
                        foreach ($dbCarts as $dbCart) {
                            if ($dbCart->id) {
                                $cart[$dbCart->id] = [
                                    'name' => $dbCart->name,
                                    'cover' => $dbCart->cover,
                                    'discount_price' => $dbCart->discount_price,
                                    'quantity' => $dbCart->quantity,
                                ];
                            }
                        }

                        session()->put('cart', $cart);
                    } else {
                        $cart = session()->get('cart', []);
                    }
                @endphp

                @if ($cart && count($cart) > 0)
                    @foreach ($cart as $id => $item)
                        <div class="flex items-center gap-3 p-3 bg-[#2A2A2A] rounded-xl cart-item"
                            data-id="{{ $id }}">
                            <img src="{{ Storage::url($item['cover']) }}" alt="{{ $item['name'] }}"
                                class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="text-white font-semibold text-sm mb-1">{{ $item['name'] }}</h4>
                                <p class="text-belibang-grey text-xs">Rp
                                    {{ number_format($item['discount_price'], 0, ',', '.') }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <button type="button" onclick="updateCartQuantity({{ $id }}, -1)"
                                        class="w-6 h-6 bg-[#414141] hover:bg-[#510825] text-white rounded flex items-center justify-center transition-all">-</button>
                                    <span
                                        class="text-white text-sm w-6 text-center quantity-display">{{ $item['quantity'] }}</span>
                                    <button type="button" onclick="updateCartQuantity({{ $id }}, 1)"
                                        class="w-6 h-6 bg-[#414141] hover:bg-[#510825] text-white rounded flex items-center justify-center transition-all">+</button>
                                </div>
                            </div>
                            <button type="button" onclick="removeCartItem({{ $id }})"
                                class="text-red-500 hover:text-red-400 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div id="empty-cart" class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-belibang-grey mb-3"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-belibang-grey">Keranjang Anda masih kosong</p>
                    </div>
                @endif
            </div>

            <!-- Cart Summary -->
            @if ($cart && count($cart) > 0)
                @php
                    $total = collect($cart)->sum(function ($item) {
                        return $item['discount_price'] * $item['quantity'];
                    });
                @endphp
                <div id="cart-summary" class="border-t border-[#414141] pt-4">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-belibang-grey">Total:</span>
                        <span id="cart-total" class="text-white font-bold text-xl">Rp
                            {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('cart.checkout') }}"
                        class="block w-full bg-[#510825] hover:bg-[#6B0A32] text-white font-bold py-3 rounded-xl transition-all duration-300 text-center">
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
            <button type="button" id="mobile-cart-button"
                class="flex items-center justify-between w-full text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 py-2 mb-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Keranjang</span>
                </div>
                <span id="mobile-cart-count"
                    class="bg-red-600 text-white text-xs font-bold rounded-full px-2 py-1 {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
            </button>

            <!-- Mobile Navigation Links -->
            <div class="space-y-4 mb-6">
                <a href="{{ route('front.index') }}"
                    class="block text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 py-2">Home</a>

                <!-- Mobile Categories -->
                <div class="space-y-2">
                    <button type="button" id="mobile-categories-btn"
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
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="block text-center p-3 rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">My
                            Dashboard</a>
                    @endif
                    @if (auth()->user()->role === 'buyer')
                        <a href="{{ route('admin.product_orders.transactions') }}"
                            class="block text-center p-3 rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">My
                            Dashboard</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    (function() {
        'use strict';

        document.addEventListener('DOMContentLoaded', function() {
            // ===== CATEGORY DROPDOWN (Desktop) =====
            const menuButton = document.getElementById('menu-button');
            const dropdownMenu = document.getElementById('dropdown-menu');

            if (menuButton && dropdownMenu) {
                menuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!menuButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });

                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // ===== CART DROPDOWN =====
            const cartButton = document.getElementById('cart-button');
            const mobileCartButton = document.getElementById('mobile-cart-button');
            const cartDropdown = document.getElementById('cart-dropdown');
            const closeCart = document.getElementById('close-cart');

            if (cartButton && cartDropdown) {
                cartButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    cartDropdown.classList.toggle('hidden');
                });
            }

            if (mobileCartButton && cartDropdown) {
                mobileCartButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    cartDropdown.classList.toggle('hidden');
                });
            }

            if (closeCart && cartDropdown) {
                closeCart.addEventListener('click', function() {
                    cartDropdown.classList.add('hidden');
                });
            }

            document.addEventListener('click', function(e) {
                if (cartDropdown && !cartDropdown.contains(e.target) &&
                    (!cartButton || !cartButton.contains(e.target)) &&
                    (!mobileCartButton || !mobileCartButton.contains(e.target))) {
                    cartDropdown.classList.add('hidden');
                }
            });

            // ===== MOBILE MENU =====
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    const spans = this.querySelectorAll('span');
                    mobileMenu.classList.toggle('hidden');

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
            }

            // ===== MOBILE CATEGORIES =====
            const mobileCategoriesBtn = document.getElementById('mobile-categories-btn');
            const mobileCategories = document.getElementById('mobile-categories');

            if (mobileCategoriesBtn && mobileCategories) {
                mobileCategoriesBtn.addEventListener('click', function() {
                    const arrow = this.querySelector('img');
                    mobileCategories.classList.toggle('hidden');
                    if (arrow) {
                        arrow.classList.toggle('rotate-180');
                    }
                });
            }

            // ===== RESIZE HANDLER =====
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024 && mobileMenu && mobileMenuBtn) {
                    const spans = mobileMenuBtn.querySelectorAll('span');
                    mobileMenu.classList.add('hidden');
                    spans[0].style.transform = 'none';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'none';
                }
            });
        });
    })();
</script>

<script>
    let pendingChanges = {};

    function updateCartQuantity(productId, change) {
        const itemElement = document.querySelector(`.cart-item[data-id='${productId}']`);
        if (!itemElement) return;

        const quantityDisplay = itemElement.querySelector('.quantity-display');
        const currentQuantity = parseInt(quantityDisplay.textContent);

        // Simpan jumlah awal jika belum disimpan
        if (!pendingChanges[productId]) {
            pendingChanges[productId] = {
                original: currentQuantity,
                current: currentQuantity
            };
        }

        // Update tampilan sementara
        let newQuantity = pendingChanges[productId].current + change;
        if (newQuantity < 1) newQuantity = 1;
        pendingChanges[productId].current = newQuantity;
        quantityDisplay.textContent = newQuantity;

        // Jika belum ada tombol konfirmasi, tambahkan
        if (!itemElement.querySelector('.confirm-buttons')) {
            const confirmContainer = document.createElement('div');
            confirmContainer.className = 'confirm-buttons flex gap-2 mt-2';

            confirmContainer.innerHTML = `
                <button type="button" class="flex-1 bg-green-600 hover:bg-green-700 text-white text-xs px-2 py-1 rounded transition-all confirm-change font-semibold">
                    ✓ OK
                </button>
                <button type="button" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-xs px-2 py-1 rounded transition-all cancel-change font-semibold">
                    ✕ Batal
                </button>
            `;

            itemElement.querySelector('.flex-1').appendChild(confirmContainer);

            // Event confirm
            confirmContainer.querySelector('.confirm-change').addEventListener('click', function() {
                const totalChange = pendingChanges[productId].current - pendingChanges[productId].original;
                fetch('{{ route('cart.update') }}', {
                        method: 'POST', // Tetap POST
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            change: totalChange
                        })
                    })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {

                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal memperbarui keranjang');
                            quantityDisplay.textContent = pendingChanges[productId].original;
                            delete pendingChanges[productId];
                            confirmContainer.remove();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memperbarui keranjang');
                        quantityDisplay.textContent = pendingChanges[productId].original;
                        delete pendingChanges[productId];
                        confirmContainer.remove();
                    });
            });

            // Event cancel
            confirmContainer.querySelector('.cancel-change').addEventListener('click', function() {
                quantityDisplay.textContent = pendingChanges[productId].original;
                delete pendingChanges[productId];
                confirmContainer.remove();
            });
        }
    }

    function removeCartItem(productId) {
        if (confirm('Hapus produk dari keranjang?')) {
            fetch('{{ route('cart.remove') }}', {
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
                        location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus produk dari keranjang');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus produk');
                });
        }
    }
</script>
