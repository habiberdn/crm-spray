@extends('front.layouts.app')
@section('title', 'Checkout - Belibang Digital Marketplace')
@section('content')

    <x-navbar />
    
    <header class="w-full pt-[74px] pb-[50px] relative z-0">
        <div class="container max-w-[1130px] mx-auto flex flex-col z-10 px-4">
            <div class="flex flex-col gap-4 mt-7 z-10">
                <h1 class="font-semibold text-3xl sm:text-4xl md:text-5xl leading-tight text-white">
                    Checkout Keranjang
                </h1>
                <p class="text-pink-100 text-sm sm:text-base">
                    Review pesanan Anda sebelum melanjutkan pembayaran
                </p>
            </div>
        </div>
        <div class="w-full h-full absolute top-0 bg-[#510825] z-0"></div>
    </header>

    <section class="container max-w-[1130px] mx-auto mb-[102px] relative -top-[30px] px-4">
        @if(session('cart') && count(session('cart')) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items Section -->
                <div class="flex-1 flex flex-col gap-6">
                    <div class="bg-white rounded-[20px] p-6 shadow-xl">
                        <h2 class="font-semibold text-xl sm:text-2xl mb-6 text-gray-800">Produk yang Dibeli</h2>
                        
                        <div class="space-y-4">
                            @php
                                $subtotal = 0;
                            @endphp
                            
                            @foreach(session('cart') as $id => $item)
                                @php
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $subtotal += $itemTotal;
                                @endphp
                                
                                <div class="flex gap-4 p-4 bg-pink-50 rounded-xl border border-pink-100 hover:shadow-md transition-all duration-300">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ Storage::url($item['image']) }}" 
                                             alt="{{ $item['name'] }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="font-semibold text-gray-800 text-sm sm:text-base mb-1 line-clamp-2">
                                                {{ $item['name'] }}
                                            </h3>
                                            <p class="text-pink-600 font-semibold text-xs sm:text-sm">
                                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                        
                                        <div class="flex items-center justify-between mt-2">
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center gap-2">
                                                <button onclick="updateCartQuantity({{ $id }}, -1)" 
                                                        class="w-7 h-7 bg-white hover:bg-pink-500 hover:text-white border border-pink-300 text-pink-600 rounded-lg flex items-center justify-center transition-all duration-200 font-semibold">
                                                    -
                                                </button>
                                                <span class="text-gray-800 font-semibold text-sm w-8 text-center">
                                                    {{ $item['quantity'] }}
                                                </span>
                                                <button onclick="updateCartQuantity({{ $id }}, 1)" 
                                                        class="w-7 h-7 bg-white hover:bg-pink-500 hover:text-white border border-pink-300 text-pink-600 rounded-lg flex items-center justify-center transition-all duration-200 font-semibold">
                                                    +
                                                </button>
                                            </div>
                                            
                                            <!-- Item Total & Remove -->
                                            <div class="flex items-center gap-3">
                                                <p class="font-bold text-gray-800 text-sm sm:text-base">
                                                    Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                                </p>
                                                <button onclick="removeCartItem({{ $id }})" 
                                                        class="text-red-500 hover:text-red-700 transition-colors p-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Checkout Summary Sidebar -->
                <div class="lg:w-[400px] flex-shrink-0">
                    <div class="bg-white rounded-[20px] p-6 shadow-xl sticky top-24">
                        <h2 class="font-semibold text-xl mb-6 text-gray-800">Ringkasan Belanja</h2>
                        
                        <!-- Order Summary -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ array_sum(array_column(session('cart'), 'quantity')) }} item)</span>
                                <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total</span>
                                    <span class="text-pink-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information Form -->
                        <form method="POST" action="{{ route('cart.process-checkout') }}" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       required
                                       value="{{ old('name', auth()->user()->name ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                                       placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       required
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                                       placeholder="email@example.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       name="phone" 
                                       required
                                       value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                                       placeholder="08123456789">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea name="address" 
                                          required
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all resize-none"
                                          placeholder="Masukkan alamat lengkap pengiriman">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea name="notes" 
                                          rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all resize-none"
                                          placeholder="Catatan untuk penjual">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full bg-pink-600 text-white font-bold py-4 rounded-full hover:bg-pink-700 active:bg-pink-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                Proses Checkout
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="{{ route('front.index') }}" 
                               class="text-pink-600 hover:text-pink-700 text-sm font-semibold inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Lanjutkan Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart State -->
            <div class="bg-white rounded-[20px] p-12 shadow-xl text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="text-2xl font-semibold text-gray-800 mb-3">Keranjang Belanja Kosong</h3>
                <p class="text-gray-600 mb-8">Anda belum menambahkan produk ke keranjang</p>
                <a href="{{ route('front.index') }}" 
                   class="inline-block bg-pink-600 text-white font-semibold py-3 px-8 rounded-full hover:bg-pink-700 transition-all duration-300 shadow-lg">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </section>

    <x-footer />

@endsection

@push('after-script')
    <script>
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
                    location.reload();
                } else {
                    showToast(data.message || 'Gagal memperbarui keranjang', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat memperbarui keranjang', 'error');
            });
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
                        location.reload();
                    } else {
                        showToast(data.message || 'Gagal menghapus produk dari keranjang', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menghapus produk', 'error');
                });
            }
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            toast.className = `fixed top-20 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-in`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('animate-slide-out');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Show session messages
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    </script>
@endpush