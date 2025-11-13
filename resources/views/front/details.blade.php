@extends('front.layouts.app')
@section('title', 'Belibang Digital Marketplace')
@section('content')

    <x-navbar />
    <header class="w-full pt-[74px] pb-[103px] relative z-0">
        <div class="container max-w-[1130px] mx-auto flex flex-col z-10 px-4">
            <div class="flex flex-col gap-4 mt-7 z-10">
                <p
                    class="bg-pink-600 border border-pink-600 rounded-xl font-semibold text-white px-4 py-2 w-fit text-sm sm:text-base leading-tight">
                    {{ $product->category->name }}
                </p>
                <h1 class="font-semibold text-3xl sm:text-4xl md:text-5xl lg:text-[55px] leading-tight text-white">
                    {{ $product->name }}
                </h1>
            </div>
        </div>
        <div class="w-full h-full absolute top-0 bg-[#510825] z-0"></div>
    </header>

    <section id="DetailsContent" class="container max-w-[1130px] mx-auto mb-8 relative -top-[70px] px-4">
        <div class="flex flex-col gap-8">
            <div
                class="w-full h-[250px] sm:h-[400px] md:h-[500px] lg:h-[700px] flex shrink-0 rounded-[20px] overflow-hidden shadow-2xl">
                <img src="{{ Storage::url($product->cover) }}" class="w-full h-full object-cover" alt="hero image">
            </div>
            <div class="flex flex-col lg:flex-row gap-8 relative -mt-[40px] lg:-mt-[93px]">
                <!-- Overview -->
                <div
                    class="flex flex-col p-6 gap-5 bg-gradient-to-br from-pink-600 to-pink-700 rounded-[20px] w-full lg:w-[700px] shrink-0 mt-6 lg:mt-[90px] h-fit shadow-xl">
                    <div class="flex flex-col gap-4">
                        <p class="font-semibold text-lg md:text-xl text-white">Overview</p>
                        <p class="text-pink-50 leading-relaxed">{{ $product->about }}</p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="flex flex-col w-full lg:w-[366px] gap-6 lg:gap-[30px] flex-nowrap overflow-y-visible">
                    @if (isset($product->diskon))
                        <div
                            class="p-[2px] bg-gradient-to-br from-pink-400 to-pink-500 rounded-[20px] flex w-full h-fit shadow-xl">
                            <div class="w-full p-6 bg-white rounded-[20px] flex flex-col gap-6">
                                <div class="flex flex-col gap-3">
                                    <p class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-gray-400 line-through">
                                        Rp {{ number_format($product->price) }}
                                    </p>
                                    @if ($product->diskon->type == 'percentage')
                                        <span
                                            class="backdrop-blur bg-pink-500 rounded-[4px] px-2 py-1 text-lg sm:text-xl font-bold text-white shadow-lg w-fit">
                                            Rp
                                            {{ number_format($product->price - ($product->price * $product->diskon->value) / 100) }}
                                        </span>
                                    @elseif($product->diskon->type == 'fixed')
                                        <span
                                            class="backdrop-blur bg-pink-500 rounded-[4px] px-2 py-1 text-lg sm:text-xl font-bold text-white shadow-lg w-fit">
                                            Rp {{ number_format($product->price - $product->diskon->value) }}
                                        </span>
                                    @endif

                                    <div class="flex flex-col gap-3 text-sm">
                                        @foreach (['100% Original Product', 'High Quality Product'] as $benefit)
                                            <div class="flex items-center gap-2">
                                                <img src="{{ asset('/images/icons/check.svg') }}" class="w-4 h-4"
                                                    alt="icon">
                                                <p class="text-gray-700">{{ $benefit }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <!-- Checkout Button -->
                                    <a href="{{ route('front.checkout', $product->slug) }}"
                                        class="bg-pink-600 text-center font-semibold py-3 px-5 rounded-full hover:bg-pink-700 active:bg-pink-800 transition-all duration-300 text-white shadow-lg">
                                        Checkout
                                    </a>

                                    <!-- Add to Cart Button -->
                                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="bg-pink-600 text-center font-semibold py-3 px-5 rounded-full hover:bg-pink-700 active:bg-pink-800 transition-all duration-300 text-white shadow-lg w-full">
                                            + Keranjang
                                        </button>
                                    </form>
                                </div>

                                <p class="text-sm text-gray-600">
                                    Butuh informasi lebih lanjut?
                                    <a href="https://wa.link/gfhop2"
                                        class="text-green-500 hover:text-green-600 font-semibold">Whatsapp</a>
                                </p>
                            </div>
                        </div>
                    @else
                        <div
                            class="p-[2px] bg-gradient-to-br from-pink-400 to-pink-500 rounded-[20px] flex w-full h-fit shadow-xl">
                            <div class="w-full p-6 bg-white rounded-[20px] flex flex-col gap-6">
                                <div class="flex flex-col gap-3">
                                    <p
                                        class="font-semibold text-2xl sm:text-3xl lg:text-4xl bg-clip-text bg-gradient-to-r from-pink-500 to-pink-600 text-transparent">
                                        Rp {{ number_format($product->price) }}
                                    </p>

                                    <div class="flex flex-col gap-3 text-sm">
                                        @foreach (['100% Original Product', 'High Quality Product'] as $benefit)
                                            <div class="flex items-center gap-2">
                                                <img src="{{ asset('/images/icons/check.svg') }}" class="w-4 h-4"
                                                    alt="icon">
                                                <p class="text-gray-700">{{ $benefit }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <!-- Checkout Button -->
                                    <a href="{{ route('front.checkout', $product->slug) }}"
                                        class="bg-pink-600 text-center font-semibold py-3 px-5 rounded-full hover:bg-pink-700 active:bg-pink-800 transition-all duration-300 text-white shadow-lg">
                                        Checkout
                                    </a>

                                    <!-- Add to Cart Button -->
                                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="bg-pink-600 text-center font-semibold py-3 px-5 rounded-full hover:bg-pink-700 active:bg-pink-800 transition-all duration-300 text-white shadow-lg w-full">
                                            + Keranjang
                                        </button>
                                    </form>
                                </div>

                                <p class="text-sm text-gray-600">
                                    Butuh informasi lebih lanjut?
                                    <a href="https://wa.link/gfhop2"
                                        class="text-green-500 hover:text-green-600 font-semibold">Whatsapp</a>
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Creator -->
                    <div
                        class="w-full p-6 bg-pink-50 border border-pink-200 rounded-[20px] flex flex-col gap-4 h-fit shadow-lg">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-3 items-center">
                                <img src="{{ Storage::url($product->creator->avatar) }}"
                                    class="w-12 h-12 rounded-full object-cover border-2 border-pink-300" alt="icon">
                                <div class="flex flex-col">
                                    <p class="font-semibold text-gray-800">{{ $product->creator->name }}</p>
                                    <p class="text-gray-600 text-sm leading-5">
                                        <span
                                            class="font-semibold mr-1 text-pink-600">{{ count($creator_products) }}</span>
                                        Product
                                    </p>
                                </div>
                            </div>
                            <a href="">
                                <img src="{{ asset('/images/icons/arrow-right.svg') }}" alt="icon" class="w-6 h-6">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="NewProduct" class="container max-w-[1130px] mx-auto mb-[102px] flex flex-col gap-8 px-4">
        <h2 class="font-semibold text-2xl md:text-3xl lg:text-[32px]">More Product</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($other_products as $product)
                @php
                    $hasDiscount = $product->diskon !== null;
                    $finalPrice = $product->price;
                    if ($hasDiscount) {
                        if ($product->diskon->type == 'percentage') {
                            $finalPrice = $product->price - ($product->price * $product->diskon->value) / 100;
                        } else {
                            $finalPrice = $product->price - $product->diskon->value;
                        }
                    }
                @endphp

                <div
                    class="product-card flex flex-col rounded-[18px] bg-pink-50 overflow-hidden hover:transform hover:scale-105 transition-all duration-300 border border-pink-100 shadow-lg">
                    <!-- Product Thumbnail -->
                    <a href="{{ route('front.details', $product->slug) }}"
                        class="thumbnail w-full h-40 sm:h-[180px] flex shrink-0 overflow-hidden relative group">
                        <img src="{{ Storage::url($product->cover) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            alt="{{ $product->name }} thumbnail">
                        <div class="absolute inset-0 bg-pink-900/20 group-hover:bg-pink-900/40 transition-all duration-300">
                        </div>

                        <!-- Price Badge with Discount -->
                        <div class="absolute top-2 sm:top-3 right-2 sm:right-[14px] z-10 flex flex-col items-end gap-1">
                            @if ($hasDiscount)
                                <span
                                    class="backdrop-blur bg-pink-100/80 rounded-[4px] px-2 py-1 text-xs text-gray-600 line-through">
                                    Rp {{ number_format($product->price) }}
                                </span>
                                <span
                                    class="backdrop-blur bg-pink-500 rounded-[4px] px-2 py-1 text-xs sm:text-sm font-bold text-white shadow-lg">
                                    Rp {{ number_format($finalPrice) }}
                                </span>
                            @else
                                <p
                                    class="backdrop-blur bg-pink-100/80 rounded-[4px] p-[4px_8px] text-xs sm:text-sm font-medium text-gray-800">
                                    Rp {{ number_format($product->price) }}
                                </p>
                            @endif
                        </div>
                    </a>

                    <!-- Product Info -->
                    <div class="p-3 sm:p-[10px_14px_12px] h-full flex flex-col justify-between gap-3 sm:gap-[14px]">
                        <div class="flex flex-col gap-1 sm:gap-2">
                            <a href="{{ route('front.details', $product->slug) }}"
                                class="font-semibold text-sm sm:text-base line-clamp-2 hover:line-clamp-none hover:text-pink-600 transition-colors duration-200 text-gray-800">
                                {{ $product->name }}
                            </a>

                            <!-- Category and Discount Info -->
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="bg-pink-100 font-semibold text-xs text-pink-700 rounded-[4px] p-[4px_6px] w-fit">
                                    {{ $product->category->name }}
                                </p>

                                @if ($hasDiscount)
                                    @if ($product->diskon->type == 'percentage')
                                        <p
                                            class="bg-pink-500/20 text-pink-600 font-semibold text-xs rounded-[4px] p-[4px_6px] w-fit border border-pink-300">
                                            Hemat {{ number_format($product->diskon->value) }}%
                                        </p>
                                    @elseif ($product->diskon->type == 'fixed')
                                        <p
                                            class="bg-pink-500/20 text-pink-600 font-semibold text-xs rounded-[4px] p-[4px_6px] w-fit border border-pink-300">
                                            Hemat Rp {{ number_format($product->diskon->value) }}
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Creator Info -->
                        <div class="flex items-center gap-2 sm:gap-[6px]">
                            <div
                                class="w-5 h-5 sm:w-6 sm:h-6 flex shrink-0 items-center justify-center rounded-full overflow-hidden border border-pink-200">
                                <img src="{{ Storage::url($product->creator->avatar) }}"
                                    class="w-full h-full object-cover" alt="{{ $product->creator->name }} avatar">
                            </div>
                            <a href="#"
                                class="font-semibold text-xs text-gray-600 hover:text-pink-600 transition-colors duration-200 truncate">
                                {{ $product->creator->name }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-pink-300 text-lg">
                        <p>Belum ada produk lain tersedia</p>
                        <p class="text-sm mt-2">Silakan cek lagi nanti</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <x-footer />

@endsection

@push('after-script')
    <script>
        // Show success/error messages with better notification
        @if (session('success'))
            // Create toast notification instead of alert
            const toast = document.createElement('div');
            toast.className =
                'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in';
            toast.textContent = '{{ session('success') }}';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('animate-slide-out');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        @endif

        @if (session('error'))
            const toast = document.createElement('div');
            toast.className =
                'fixed top-20 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in';
            toast.textContent = '{{ session('error') }}';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('animate-slide-out');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        @endif
    </script>

    <script>
        // Flickity carousel
        if (typeof $ !== 'undefined' && $('.testi-carousel').length) {
            $('.testi-carousel').flickity({
                cellAlign: 'left',
                contain: true,
                pageDots: false,
                prevNextButtons: false,
            });

            $('.btn-prev').on('click', function() {
                $('.testi-carousel').flickity('previous', true);
            });

            $('.btn-next').on('click', function() {
                $('.testi-carousel').flickity('next', true);
            });
        }
    </script>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const resetButton = document.getElementById('resetButton');

        if (searchInput && resetButton) {
            searchInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    resetButton.classList.remove('hidden');
                } else {
                    resetButton.classList.add('hidden');
                }
            });

            resetButton.addEventListener('click', function() {
                resetButton.classList.add('hidden');
            });
        }
    </script>

    <script>
        // Category dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menu-button');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            if (menuButton && dropdownMenu) {
                menuButton.addEventListener('click', function() {
                    dropdownMenu.classList.toggle('hidden');
                });

                // Close the dropdown menu when clicking outside of it
                document.addEventListener('click', function(event) {
                    const isClickInside = menuButton.contains(event.target) || dropdownMenu.contains(event
                        .target);
                    if (!isClickInside) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endpush
