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

    @if ($errors->any())
        <div class="container max-w-[1130px] mx-auto px-4 -mt-8 mb-8 relative z-10">
            <div class="bg-red-500/90 backdrop-blur rounded-[20px] p-6 shadow-xl">
                <ul class="space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="text-white font-semibold flex items-start gap-2">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <section class="container max-w-[1130px] mx-auto mb-[102px] relative -top-[30px] px-4">
        @if($cart && count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items Section -->
                <div class="flex-1 flex flex-col gap-6">
                    <div class="bg-white rounded-[20px] p-6 shadow-xl">
                        <h2 class="font-semibold text-xl sm:text-2xl mb-6 text-gray-800">Produk yang Dibeli</h2>
                        
                        <div class="space-y-4">
                            @php
                                $subtotal = 0;
                            @endphp
                            
                            @foreach($cart as $id => $item)
                                @php
                                    $itemTotal = $item['discount_price'] * $item['quantity'];
                                    $subtotal += $itemTotal;
                                @endphp
                                
                                <div class="flex gap-4 p-4 bg-pink-50 rounded-xl border border-pink-100 hover:shadow-md transition-all duration-300">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-lg overflow-hidden">
                                        <img src="{{ Storage::url($item['cover']) }}" 
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
                                                Rp {{ number_format($item['discount_price'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                        
                                        <div class="flex items-center justify-between mt-2">
                                            <!-- Quantity Display (Read Only) -->
                                            <div class="flex items-center gap-2">
                                                <span class="text-gray-600 text-sm">Qty:</span>
                                                <span class="text-gray-800 font-semibold text-sm px-3 py-1 bg-white rounded-lg border border-pink-200 quantity-display">
                                                    {{ $item['quantity'] }}
                                                </span>
                                            </div>
                                            
                                            <!-- Item Total -->
                                            <div class="flex items-center gap-3">
                                                <p class="font-bold text-gray-800 text-sm sm:text-base">
                                                    Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Checkout Form Sidebar -->
                <div class="w-full lg:w-[400px] flex-shrink-0">
                    <div class="flex flex-col gap-6">
                        
                        <!-- Order Summary -->
                        <div class="bg-white rounded-[20px] p-6 shadow-xl">
                            <h2 class="font-semibold text-xl mb-6 text-gray-800">Ringkasan Belanja</h2>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ array_sum(array_column($cart, 'quantity')) }} item)</span>
                                    <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between text-lg font-bold text-gray-800">
                                        <span>Total</span>
                                        <span class="text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transfer Information -->
                        <div class="p-[2px] bg-gradient-to-br from-pink-400 to-pink-500 rounded-[20px] flex w-full h-fit shadow-xl">
                            <div class="w-full p-6 bg-white rounded-[20px] flex flex-col gap-6">
                                <h3 class="font-semibold text-xl text-gray-800">Transfer Details</h3>

                                @php
                                    // Ambil admin/owner pertama untuk transfer details
                                    $admin = \App\Models\User::where('role', 'owner')->first();
                                @endphp

                                <div class="flex flex-col gap-4">
                                    <!-- Bank Name -->
                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-medium text-gray-600">Bank Name</label>
                                        <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-lg border border-pink-200">
                                            <img src="{{ asset('images/icons/bank.svg') }}" class="w-5 h-5" alt="icon">
                                            <span class="font-semibold text-gray-800">{{ $admin->bank_name ?? 'BRI' }}</span>
                                        </div>
                                    </div>

                                    <!-- Account Name -->
                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-medium text-gray-600">Account Name</label>
                                        <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-lg border border-pink-200">
                                            <img src="{{ asset('images/icons/user-square.svg') }}" class="w-5 h-5" alt="icon">
                                            <span class="font-semibold text-gray-800">{{ $admin->bank_account ?? 'SUSI ASTUTI' }}</span>
                                        </div>
                                    </div>

                                    <!-- Account Number -->
                                    <div class="flex flex-col gap-2">
                                        <label class="text-sm font-medium text-gray-600">Account Number</label>
                                        <div class="flex items-center justify-between gap-3 p-4 bg-pink-50 rounded-lg border border-pink-200">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ asset('images/icons/card.svg') }}" class="w-5 h-5" alt="icon">
                                                <span id="account-number" class="font-semibold text-gray-800">{{ $admin->bank_account_number ?? '5469-01-004554-53-7' }}</span>
                                            </div>
                                            <button type="button" onclick="copyTextFunc()" class="text-pink-600 hover:text-pink-700 text-sm font-semibold">
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Proof Upload -->
                        <div class="p-[2px] bg-gradient-to-br from-pink-400 to-pink-500 rounded-[20px] flex w-full h-fit shadow-xl">
                            <div class="w-full p-6 bg-white rounded-[20px] flex flex-col gap-6">
                                <h3 class="font-semibold text-xl text-gray-800">Payment Confirmation</h3>
                            
                                <form method="POST" action="{{ route('front.checkout.store') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                                    @csrf

                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <p class="text-sm text-blue-700 leading-relaxed">
                                            Please upload your payment proof. We will verify and confirm your purchase as soon as possible.
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-3">
                                        <label class="text-sm font-medium text-gray-600">Upload Payment Proof</label>

                                        <button type="button"
                                            class="flex gap-2 items-center justify-center p-4 border-2 border-dashed border-pink-300 rounded-lg hover:border-pink-400 hover:bg-pink-50 transition-all duration-300"
                                            onclick="document.getElementById('proof').click()">
                                            <img src="{{ asset('images/icons/document-upload.svg') }}" class="w-5 h-5" alt="icon">
                                            <span class="font-medium text-gray-700">Choose File</span>
                                        </button>

                                        <input type="file" name="proof" id="proof" class="hidden" onchange="previewFile()" accept="image/*" required>

                                        <div class="relative rounded-lg overflow-hidden bg-pink-50 border border-pink-200 h-[120px]">
                                            <div class="relative file-preview z-10 w-full h-full hidden">
                                                <img src="{{ asset('images/icons/check.svg') }}"
                                                    class="check-icon absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 w-12 h-12 z-20"
                                                    alt="icon">
                                                <img src="" class="thumbnail-proof w-full h-full object-cover" alt="thumbnail">
                                            </div>
                                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                                                <img src="{{ asset('images/icons/gallery.svg') }}" class="w-8 h-8 opacity-40" alt="icon">
                                                <p class="text-sm text-gray-400">Preview will appear here</p>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="bg-pink-600 text-center font-semibold py-4 px-5 rounded-full hover:bg-pink-700 active:bg-pink-800 transition-all duration-300 text-white shadow-lg mt-2">
                                        Complete Checkout
                                    </button>
                                </form>

                                <div class="flex items-center gap-2 pt-4 border-t border-gray-200">
                                    <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-xs text-gray-600">Your payment is secure and encrypted</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
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
        function previewFile() {
            const preview = document.querySelector('.file-preview');
            const thumbnail = document.querySelector('.thumbnail-proof');
            const file = document.getElementById('proof').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                thumbnail.src = reader.result;
                preview.classList.remove('hidden');
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function copyTextFunc() {
            const accountNumber = document.getElementById('account-number').textContent;
            
            // Modern way using Clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(accountNumber).then(function() {
                    showToast('Nomor rekening berhasil disalin!', 'success');
                }, function() {
                    fallbackCopy(accountNumber);
                });
            } else {
                fallbackCopy(accountNumber);
            }
        }

        function fallbackCopy(text) {
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            document.body.appendChild(textArea);
            textArea.select();
            
            try {
                document.execCommand('copy');
                showToast('Nomor rekening berhasil disalin!', 'success');
            } catch (err) {
                showToast('Gagal menyalin nomor rekening', 'error');
            }
            
            document.body.removeChild(textArea);
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            toast.className = `fixed top-20 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300`;
            toast.style.animation = 'slideInRight 0.3s ease-out';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-in';
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

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endpush