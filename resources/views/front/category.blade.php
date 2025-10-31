@extends('front.layouts.app')
@section('title', 'Belibang Digital Marketplace')
@section('content')

    <x-navbar />
    <header
        class="w-full pt-16 sm:pt-[74px] pb-8 sm:pb-[34px] bg-[url('{{ asset('images/backgrounds/hero-image.png') }}')] bg-cover bg-no-repeat bg-center relative z-0 min-h-[400px] sm:min-h-[500px]">
        <div
            class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center gap-6 sm:gap-[34px] z-10 h-full">
            >
            <div class="flex flex-col gap-2 text-center w-fit mt-20 z-10">
                <h1 class="font-semibold text-[60px] leading-[130%]">{{ $category->name }}</h1>
            </div>
             <div class="flex w-full justify-center mb-6 sm:mb-[34px] z-10 px-4">
                <form action="{{ route('front.search') }}" method="GET"
                    class="group/search-bar p-3 sm:p-[14px_18px] bg-pink-50 ring-1 ring-pink-200 hover:ring-pink-300 max-w-[560px] w-full rounded-full transition-all duration-300">
                    <div class="relative text-left">
                        <button type="button" class="absolute inset-y-0 left-0 flex items-center pl-1">
                            <img src="{{ asset('images/icons/search-normal.svg') }}" alt="search icon"
                                class="w-4 h-4 sm:w-5 sm:h-5">
                        </button>
                        <input name="keyword" type="text" id="searchInput"
                            class="bg-pink-50 w-full pl-8 sm:pl-[36px] pr-10 focus:outline-none placeholder:text-pink-300 text-sm sm:text-base text-gray-800"
                            placeholder="Type anything to search..." />
                        <button type="reset" id="resetButton"
                            class="close-button hidden w-6 h-6 sm:w-[38px] sm:h-[38px] flex shrink-0 bg-[url('{{ asset('images/icons/close.svg') }}')] hover:bg-[url('{{ asset('images/icons/close-white.svg') }}')] transition-all duration-300 appearance-none absolute top-1/2 right-2 transform -translate-y-1/2">
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-full h-full absolute top-0 bg-gradient-to-b from-pink-900/70 to-pink-950 z-0"></div>
    </header>

    <section id="NewProduct" class="container max-w-[1130px] mx-auto mb-[102px] flex flex-col gap-8">
        <h2 class="font-semibold text-[32px]">Product</h2>
        <div class="grid grid-cols-4 gap-[22px]">

            @forelse($product_categories as $product)
                <div
                    class="product-card flex flex-col rounded-[18px] bg-pink-50 overflow-hidden hover:transform hover:scale-105 transition-all duration-300 border border-pink-100">
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
                            @if ($product->diskon)
                                <span
                                    class="backdrop-blur bg-pink-100/80 rounded-[4px] px-2 py-1 text-xs text-gray-600 line-through">
                                    Rp {{ number_format($product->price) }}
                                </span>
                                @if ($product->diskon && $product->diskon->type == 'percentage')
                                    <span
                                        class="backdrop-blur bg-pink-500 rounded-[4px] px-2 py-1 text-xs sm:text-sm font-bold text-white shadow-lg">
                                        Rp
                                        {{ number_format($product->price - ($product->price * $product->diskon->value) / 100) }}
                                    </span>
                                @elseif($product->diskon && $product->diskon->type == 'fixed')
                                    <span
                                        class="backdrop-blur bg-pink-500 rounded-[4px] px-2 py-1 text-xs sm:text-sm font-bold text-white shadow-lg">
                                        Rp {{ number_format($product->price - $product->diskon->value) }}
                                    </span>
                                @else
                                    <p
                                        class="backdrop-blur bg-pink-100/80 rounded-[4px] p-[4px_8px] text-xs sm:text-sm font-medium text-gray-800">
                                        Rp {{ number_format($product->price) }}
                                    </p>
                                @endif
                            @else
                                <span class="backdrop-blur bg-pink-100/80 rounded-[4px] px-2 py-1 text-xs text-gray-600">
                                    Rp {{ number_format($product->price) }}
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

                                @if ($product->diskon)
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
                                <img src="{{ Storage::url($product->creator->avatar) }}" class="w-full h-full object-cover"
                                    alt="{{ $product->creator->name }} avatar">
                            </div>
                            <a href="#"
                                class="font-semibold text-xs text-gray-600 hover:text-pink-600 transition-colors duration-200 truncate">
                                {{ $product->creator->name }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>
                    Belum ada produk tersedia.
                </p>
            @endforelse
        </div>
    </section>


    <x-footer />

@endsection

@push('after-script')
    <script>
        $('.testi-carousel').flickity({
            // options
            cellAlign: 'left',
            contain: true,
            pageDots: false,
            prevNextButtons: false,
        });

        // previous
        $('.btn-prev').on('click', function() {
            $('.testi-carousel').flickity('previous', true);
        });

        // next
        $('.btn-next').on('click', function() {
            $('.testi-carousel').flickity('next', true);
        });
    </script>

    <script>
        const searchInput = document.getElementById('searchInput');
        const resetButton = document.getElementById('resetButton');

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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menu-button');
            const dropdownMenu = document.querySelector('.dropdown-menu');

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
        });
    </script>
@endpush