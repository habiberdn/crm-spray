<div
    class="product-card flex flex-col rounded-[18px] bg-pink-50 overflow-hidden hover:transform hover:scale-105 transition-all duration-300 border border-pink-100">
    <!-- Product Thumbnail -->
    <a href="{{ route('front.details', $product->slug) }}"
        class="thumbnail w-full h-40 sm:h-[180px] flex shrink-0 overflow-hidden relative group">
        <img src="{{ $cover }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
            alt="{{ $product->name }} thumbnail">
        <div class="absolute inset-0 bg-pink-900/20 group-hover:bg-pink-900/40 transition-all duration-300"></div>

        <!-- Price Badge with Discount -->
        <div class="absolute top-2 sm:top-3 right-2 sm:right-[14px] z-10 flex flex-col items-end gap-1">
            @if ($product->diskon)
                <span class="backdrop-blur bg-pink-100/80 rounded-[4px] px-2 py-1 text-xs text-gray-600 line-through">
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
                <span class="backdrop-blur bg-pink-100/80 rounded-[4px] px-2 py-1 text-sm text-gray-600">
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
