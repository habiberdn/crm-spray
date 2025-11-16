@extends('front.layouts.app')
@section('title', 'Belibang Marketplace Indonesia')
@section('content')

    <x-navbar />

    <!-- Hero Section -->
    <header
        class="w-full pt-16 sm:pt-[74px] pb-8 sm:pb-[34px] bg-[url('{{ asset('images/backgrounds/backgrounf.jpeg') }}')] bg-cover bg-no-repeat bg-center relative z-0 min-h-[400px] sm:min-h-[500px]">
        <div
            class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center gap-6 sm:gap-[34px] z-10 h-full">
            <!-- Hero Title -->
            <div class="flex flex-col gbap-2 text-center w-full mt-10 sm:mt-20 z-10">
                <h1 class="font-semibold text-2xl sm:text-4xl md:text-5xl lg:text-[60px] leading-[130%] text-white px-4">
                    Explore High Quality<br class="hidden sm:block">
                    <span class="block sm:inline">Bed Sheets and Covers</span>
                </h1>
            </div>


        </div>
        <div class="w-full h-full absolute top-0 bg-gradient-to-b from-pink-900/70 to-pink-950 z-0"></div>
    </header>

    <!-- Filter Section -->
    <section id="Filter" class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <form id="filterForm" method="GET" action="{{ route('front.index') }}"
                class="flex flex-col sm:flex-row gap-4">
                <!-- Category Filter -->
                <div class="flex-1">
                    <label for="categoryFilter" class="block text-sm font-medium text-gray-700 mb-2">
                        Filter by Category
                    </label>
                    <select name="category" id="categoryFilter"
                        class="w-full px-4 py-3 border border-pink-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 text-black">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
               
                <!-- Subcategory Filter -->
                <div class="flex-1">
                    <label for="subcategoryFilter" class="block text-sm font-medium text-gray-700 mb-2">
                        Filter by Subcategory
                    </label>
                    <select name="subcategory" id="subcategoryFilter"
                        class="w-full px-4 py-3 border border-pink-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 text-black">
                        <option value="">All Subcategories</option>

                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}"
                                {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="flex gap-2 items-end">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                        Apply Filter
                    </button>
                    <a href="{{ route('front.index') }}"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- Products Section -->
    <section id="NewProduct"
        class="container max-w-[1130px] mx-auto px-4 sm:px-6 lg:px-8 mb-16 sm:mb-[102px] flex flex-col gap-6 sm:gap-8">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl sm:text-2xl lg:text-[32px]">
                @if (request('category') || request('subcategory'))
                    Filtered Products
                @else
                    All Products
                @endif
            </h2>
            <p class="text-gray-600">
                <span class="font-semibold text-pink-600">{{ $products->total() }}</span> products found
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-[22px]">
            @forelse($products as $product)
                <x-card :product="$product" :cover="Storage::url($product->cover)" />
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-pink-300 text-lg">
                        <p>No products found</p>
                        <p class="text-sm mt-2">Try adjusting your filters</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </section>

    <x-footer />
    getSubcategories
@endsection

@push('after-script')
    <script>
        // Category and Subcategory Filter  
        document.addEventListener('DOMContentLoaded', function() {
            const categoryFilter = document.getElementById('categoryFilter');
            const subcategoryFilter = document.getElementById('subcategoryFilter');

            categoryFilter.addEventListener('change', function() {
                const categoryId = this.value;

                // Reset subcategory
                subcategoryFilter.innerHTML = '<option value="">All Subcategories</option>';

                if (categoryId) {
                    // Enable subcategory filter
                    subcategoryFilter.disabled = false;

                    // Fetch subcategories via AJAX
                    fetch(`/get-subcategories?category_id=${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(subcategory => {
                                const option = document.createElement('option');
                                option.value = subcategory.id;
                                option.textContent = subcategory.name;
                                subcategoryFilter.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching subcategories:', error);
                        });
                }
            });
        });

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

            $('.btn-prev').on('click', function() {
                $('.testi-carousel').flickity('previous', true);
            });

            $('.btn-next').on('click', function() {
                $('.testi-carousel').flickity('next', true);
            });
        }

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

            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                searchInput.value = '';
                resetButton.classList.add('hidden');
                searchInput.focus();
            });
        }

        // Menu dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menu-button');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            if (menuButton && dropdownMenu) {
                menuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(event) {
                    if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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
        a:focus,
        select:focus {
            outline: 2px solid #ec4899;
            outline-offset: 2px;
        }

      
    </style>
@endpush
