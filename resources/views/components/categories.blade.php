@props(['category'])

<a href="{{ route('front.category', $category) }}"
    class="group category-card flex-shrink-0 w-40 sm:w-48 h-fit p-[2px] rounded-2xl bg-gradient-to-br from-pink-400 to-pink-300 hover:from-pink-500 hover:to-pink-400 transition-all duration-300 shadow-lg hover:shadow-xl">
    <div
        class="flex flex-col p-4 sm:p-[18px] rounded-2xl bg-gradient-to-br from-pink-50 to-white group-active:bg-pink-100 transition-all duration-300">
        <div class="w-10 h-10 sm:w-[50px] sm:h-[50px] flex shrink-0 items-center justify-center bg-pink-100 rounded-xl">
            <img src="{{ asset($category->icon) }}" alt="{{ $category->name }} icon" class="w-full h-full object-contain">
        </div>
        <div class="px-1 sm:px-[6px] flex flex-col text-left mt-2 sm:mt-[8px]">
            <p class="font-bold text-xs sm:text-sm text-pink-700">{{ $category->name }}</p>
        </div>
    </div>
</a>