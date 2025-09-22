@extends('front.layouts.app')
@section('title', 'Belibang Marketplace Indonesia')
@section('content')

<x-navbar/>

<!-- Hero Section -->
<header class="w-full pt-16 sm:pt-[74px] pb-8 sm:pb-[34px] bg-[url('{{asset('images/backgrounds/hero-image.png')}}')] bg-cover bg-no-repeat bg-center relative z-0 min-h-[400px] sm:min-h-[500px]">
    <div class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center gap-6 sm:gap-[34px] z-10 h-full">
        <!-- Hero Title -->
        <div class="flex flex-col gap-2 text-center w-full mt-10 sm:mt-20 z-10">
            <h1 class="font-semibold text-2xl sm:text-4xl md:text-5xl lg:text-[60px] leading-[130%] text-white px-4">
                Explore High Quality<br class="hidden sm:block">
                <span class="block sm:inline">Bed Sheets and Covers</span>
            </h1>
        </div>
        
        <!-- Search Bar -->
        <div class="flex w-full justify-center mb-6 sm:mb-[34px] z-10 px-4">
            <form action="{{route('front.search')}}" method="GET" class="group/search-bar p-3 sm:p-[14px_18px] bg-belibang-darker-grey ring-1 ring-[#414141] hover:ring-[#888888] max-w-[560px] w-full rounded-full transition-all duration-300">
                <div class="relative text-left">
                    <button type="button" class="absolute inset-y-0 left-0 flex items-center pl-1">
                        <img src="{{asset('images/icons/search-normal.svg')}}" alt="search icon" class="w-4 h-4 sm:w-5 sm:h-5">
                    </button>
                    <input name="keyword" type="text" id="searchInput"
                        class="bg-belibang-darker-grey w-full pl-8 sm:pl-[36px] pr-10 focus:outline-none placeholder:text-[#595959] text-sm sm:text-base text-white"
                        placeholder="Type anything to search..." />
                    <button type="reset" id="resetButton"
                        class="close-button hidden w-6 h-6 sm:w-[38px] sm:h-[38px] flex shrink-0 bg-[url('{{asset('images/icons/close.svg')}}')] hover:bg-[url('{{asset('images/icons/close-white.svg')}}')] transition-all duration-300 appearance-none absolute top-1/2 right-2 transform -translate-y-1/2">
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="w-full h-full absolute top-0 bg-gradient-to-b from-belibang-black/70 to-belibang-black z-0"></div>
</header>

<!-- Category Section -->
<section id="Category" class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-8 mb-16 sm:mb-[102px] flex flex-col gap-6 sm:gap-8 mt-8 sm:mt-12">
    <h2 class="font-semibold text-xl sm:text-2xl lg:text-[32px] text-center sm:text-left">Category</h2>
    
    <!-- Desktop Categories -->
    <div class="hidden lg:flex justify-between items-center">
        <a href="{{route('front.index')}}"
            class="group category-card w-fit h-fit p-[1px] rounded-2xl bg-img-transparent hover:bg-img-purple-to-orange transition-all duration-300">
            <div class="flex flex-col p-[18px] rounded-2xl w-[210px] bg-img-black-gradient group-active:bg-img-black transition-all duration-300">
                <div class="w-[50px] h-[50px] flex shrink-0 items-center justify-center">
                    <img src="{{asset('images/trolley.png')}}" alt="all products icon">
                </div>
                <div class="px-[6px] flex flex-col text-left mt-[8px]">
                    <p class="font-bold text-sm">Semua Produk</p>
                </div>
            </div>
        </a>

        @forelse($categories as $category)
        <a href="{{route('front.category', $category)}}"
            class="group category-card w-fit h-fit p-[1px] rounded-2xl bg-img-transparent hover:bg-img-purple-to-orange transition-all duration-300">
            <div class="flex flex-col p-[18px] rounded-2xl w-[210px] bg-img-black-gradient group-active:bg-img-black transition-all duration-300">
                <div class="w-[50px] h-[50px] flex shrink-0 items-center justify-center">
                    <img src="{{asset($category->icon)}}" alt="{{$category->name}} icon">
                </div>
                <div class="px-[6px] flex flex-col text-left mt-[8px]">
                    <p class="font-bold text-sm">{{$category->name}}</p>
                </div>
            </div>
        </a>
        @empty
        @endforelse
    </div>

    <!-- Mobile & Tablet Categories - Scrollable -->
    <div class="lg:hidden">
        <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
            <!-- All Products Card -->
            <a href="{{route('front.index')}}"
                class="group category-card flex-shrink-0 w-40 sm:w-48 h-fit p-[1px] rounded-2xl bg-img-transparent hover:bg-img-purple-to-orange transition-all duration-300">
                <div class="flex flex-col p-4 sm:p-[18px] rounded-2xl bg-img-black-gradient group-active:bg-img-black transition-all duration-300">
                    <div class="w-10 h-10 sm:w-[50px] sm:h-[50px] flex shrink-0 items-center justify-center">
                        <img src="{{asset('images/trolley.png')}}" alt="all products icon" class="w-full h-full object-contain">
                    </div>
                    <div class="px-1 sm:px-[6px] flex flex-col text-left mt-2 sm:mt-[8px]">
                        <p class="font-bold text-xs sm:text-sm">Semua Produk</p>
                    </div>
                </div>
            </a>

            @forelse($categories as $category)
            <a href="{{route('front.category', $category)}}"
                class="group category-card flex-shrink-0 w-40 sm:w-48 h-fit p-[1px] rounded-2xl bg-img-transparent hover:bg-img-purple-to-orange transition-all duration-300">
                <div class="flex flex-col p-4 sm:p-[18px] rounded-2xl bg-img-black-gradient group-active:bg-img-black transition-all duration-300">
                    <div class="w-10 h-10 sm:w-[50px] sm:h-[50px] flex shrink-0 items-center justify-center">
                        <img src="{{asset($category->icon)}}" alt="{{$category->name}} icon" class="w-full h-full object-contain">
                    </div>
                    <div class="px-1 sm:px-[6px] flex flex-col text-left mt-2 sm:mt-[8px]">
                        <p class="font-bold text-xs sm:text-sm">{{$category->name}}</p>
                    </div>
                </div>
            </a>
            @empty
            @endforelse
        </div>
    </div>
</section>

<!-- New Products Section -->
<section id="NewProduct" class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-8 mb-16 sm:mb-[102px] flex flex-col gap-6 sm:gap-8">
    <h2 class="font-semibold text-xl sm:text-2xl lg:text-[32px] text-center sm:text-left">New Product</h2>
    
    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-[22px]">
        @forelse($products as $product)
            <div class="product-card flex flex-col rounded-[18px] bg-[#181818] overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <!-- Product Thumbnail -->
                <a href="{{route('front.details', $product->slug)}}" class="thumbnail w-full h-40 sm:h-[180px] flex shrink-0 overflow-hidden relative group">
                    <img src="{{Storage::url($product->cover)}}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" alt="{{$product->name}} thumbnail">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-all duration-300"></div>
                    <p class="backdrop-blur bg-black/30 rounded-[4px] p-[4px_8px] absolute top-2 sm:top-3 right-2 sm:right-[14px] z-10 text-xs sm:text-sm font-medium">
                        Rp {{number_format($product->price)}}
                    </p>
                </a>
                
                <!-- Product Info -->
                <div class="p-3 sm:p-[10px_14px_12px] h-full flex flex-col justify-between gap-3 sm:gap-[14px]">
                    <div class="flex flex-col gap-1 sm:gap-2">
                        <a href="{{route('front.details', $product->slug)}}" 
                           class="font-semibold text-sm sm:text-base line-clamp-2 hover:line-clamp-none hover:text-purple-400 transition-colors duration-200">
                            {{$product->name}}
                        </a>
                        <p class="bg-[#2A2A2A] font-semibold text-xs text-belibang-grey rounded-[4px] p-[4px_6px] w-fit">
                            {{$product->category->name}}
                        </p>
                    </div>
                    
                    <!-- Creator Info -->
                    <div class="flex items-center gap-2 sm:gap-[6px]">
                        <div class="w-5 h-5 sm:w-6 sm:h-6 flex shrink-0 items-center justify-center rounded-full overflow-hidden">
                            <img src="{{Storage::url($product->creator->avatar)}}" class="w-full h-full object-cover" alt="{{$product->creator->name}} avatar">
                        </div>
                        <a href="#" class="font-semibold text-xs text-belibang-grey hover:text-white transition-colors duration-200 truncate">
                            {{$product->creator->name}}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 text-lg">
                    <p>Belum ada produk tersedia</p>
                    <p class="text-sm mt-2">Silakan cek lagi nanti</p>
                </div>
            </div>
        @endforelse
    </div>
</section>

<x-footer/>

@endsection

@push('after-script')
<script>
    // Flickity carousel initialization
    if (typeof $ !== 'undefined' && $.fn.flickity) {
        $('.testi-carousel').flickity({
            cellAlign: 'left',
            contain: true,
            pageDots: false,
            prevNextButtons: false,
            adaptiveHeight: true,
            wrapAround: true
        });

        $('.btn-prev').on('click', function () {
            $('.testi-carousel').flickity('previous', true);
        });

        $('.btn-next').on('click', function () {
            $('.testi-carousel').flickity('next', true);
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const resetButton = document.getElementById('resetButton');

    if (searchInput && resetButton) {
        searchInput.addEventListener('input', function () {
            if (this.value.trim() !== '') {
                resetButton.classList.remove('hidden');
            } else {
                resetButton.classList.add('hidden');
            }
        });

        resetButton.addEventListener('click', function (e) {
            e.preventDefault();
            searchInput.value = '';
            resetButton.classList.add('hidden');
            searchInput.focus();
        });
    }

    // Menu dropdown functionality
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.getElementById('menu-button');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        if (menuButton && dropdownMenu) {
            menuButton.addEventListener('click', function (e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

<style>
    /* Custom scrollbar for horizontal scroll */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    /* Smooth hover transitions */
    .product-card {
        will-change: transform;
    }
    
    /* Better focus states for accessibility */
    input:focus,
    button:focus,
    a:focus {
        outline: 2px solid #8B5CF6;
        outline-offset: 2px;
    }
</style>
@endpush