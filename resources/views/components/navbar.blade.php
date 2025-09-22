<nav class="w-full fixed top-0 bg-[#00000010] backdrop-blur-lg z-10">
    <div class="container max-w-[1130px] mx-auto flex items-center justify-between h-[74px] px-4 md:px-6">
        <!-- Logo -->
        <div class="flex items-center gap-4 md:gap-[26px]">
            <a href="{{route('front.index')}}" class="flex w-[100px] md:w-[154px] shrink-0 items-center">
                <img src="{{asset('images/logos/WhatsApp Image 2025-09-06 at 10.32.48.svg')}}" alt="logo" class="w-8 md:w-12 border rounded-full">
            </a>
            
            <!-- Desktop Menu -->
            <ul class="hidden lg:flex gap-6 items-center">
                <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                    <a href="{{route('front.index')}}">Home</a>
                </li>
                <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 relative">
                    <button id="menu-button" class="flex items-center gap-1 focus:text-belibang-light-grey">
                        <span>Categories</span>
                        <img src="{{asset('images/icons/arrow-down.svg')}}" alt="icon">
                    </button>
                    <div class="dropdown-menu hidden absolute top-[52px] grid grid-cols-2 p-4 gap-[10px] w-[526px] rounded-[20px] bg-[#1E1E1E] border border-[#414141] z-10">
                        <div class="col-span-2 flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{route('front.category', 0)}}" class="w-[50px] h-[58px] flex shrink-0 flex items-center">
                                    <img src="{{asset('images/trolley.png')}}" alt="icon">
                                </a>
                                <a href="" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Semua Produk</p>
                                </a>
                            </div>
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="{{asset('images/icons/crown.svg')}}" alt="icon">
                            </div>
                        </div>
                        <div class="flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{route('front.category', 1)}}" class="w-[40px] h-[40px] flex shrink-0 flex items-center">
                                    <img src="{{asset('images/pillow.png')}}" alt="icon">
                                </a>
                                <a href="{{route('front.category', 3)}}" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Bantal</p>
                                </a>
                            </div>
                        </div>
                        <div class="flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{route('front.category', 2)}}" class="w-[40px] h-[40px] flex shrink-0 flex items-center"> 
                                    <img src="{{asset('images/double-bed.png')}}" alt="icon">
                                 </a>
                                <a href="{{route('front.category', 2)}}" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Seprai</p>
                                </a>
                            </div>
                        </div>
                        <div class="flex justify-between items-center rounded-2xl p-[12px_16px] border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <a href="{{route('front.category', 3)}}" class="w-[40px] h-[40px] flex shrink-0 flex items-center">
                                    <img src="{{asset('images/other.png')}}" alt="icon">
                                </a>
                                <a href="{{route('front.category', 1)}}" class="flex flex-col">
                                    <p class="font-bold text-sm text-white">Lainnya</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Desktop Auth Buttons -->
        <div class="hidden md:flex gap-4 md:gap-6 items-center">
            @guest
            <a href="{{route('login')}}" class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 text-sm md:text-base">Masuk</a>
            <a href="{{route('register')}}" class="p-[6px_12px] md:p-[8px_16px] w-fit h-fit rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300 text-sm md:text-base">Daftar</a>
            @endguest

            @auth
            <a href="{{route('admin.dashboard')}}" class="p-[6px_12px] md:p-[8px_16px] w-fit h-fit rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300 text-sm md:text-base">My Dashboard</a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden flex flex-col gap-1 p-2 focus:outline-none">
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
            <span class="w-6 h-0.5 bg-white transition-all duration-300"></span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden bg-[#1E1E1E] border-t border-[#414141]">
        <div class="container max-w-[1130px] mx-auto px-4 py-4">
            <!-- Mobile Navigation Links -->
            <div class="space-y-4 mb-6">
                <a href="{{route('front.index')}}" class="block text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 py-2">Home</a>
                
                <!-- Mobile Categories -->
                <div class="space-y-2">
                    <button id="mobile-categories-btn" class="flex items-center justify-between w-full text-belibang-grey hover:text-belibang-light-grey transition-all duration-300 py-2">
                        <span>Categories</span>
                        <img src="{{asset('images/icons/arrow-down.svg')}}" alt="icon" class="transform transition-transform duration-300">
                    </button>
                    
                    <div id="mobile-categories" class="hidden space-y-2 pl-4">
                        <a href="{{route('front.category', 1)}}" class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{asset('images/trolley.png')}}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Semua Produk</span>
                        </a>
                        <a href="{{route('front.category', 3)}}" class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{asset('images/pillow.png')}}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Bantal</span>
                        </a>
                        <a href="{{route('front.category', 2)}}" class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{asset('images/double-bed.png')}}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Seprai</span>
                        </a>
                        <a href="{{route('front.category', 3)}}" class="flex items-center gap-3 py-3 px-4 rounded-2xl border border-[#414141] hover:bg-[#2A2A2A] transition-all duration-300">
                            <img src="{{asset('images/other.png')}}" alt="icon" class="w-8 h-8">
                            <span class="font-bold text-sm text-white">Lainnya</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile Auth Buttons -->
            <div class="space-y-3 pt-4 border-t border-[#414141]">
                @guest
                <a href="{{route('login')}}" class="block text-center py-3 text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">Masuk</a>
                <a href="{{route('register')}}" class="block text-center p-3 rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">Daftar</a>
                @endguest

                @auth
                <a href="{{route('admin.dashboard')}}" class="block text-center p-3 rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">My Dashboard</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const menuButton = document.getElementById('menu-button');
    const dropdown = document.querySelector('.dropdown-menu');
    
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