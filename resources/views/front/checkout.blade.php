@extends('front.layouts.app')
@section('title', 'Checkout - Belibang Digital Marketplace')
@section('content')

    <x-navbar />

    <!-- Header Section -->
    <header class="w-full pt-[74px] pb-[103px] relative z-0">
        <div class="container max-w-[1130px] mx-auto flex flex-col z-10 px-4">
            <div class="flex flex-col gap-4 mt-7 z-10">
                <h1 class="font-semibold text-3xl sm:text-4xl md:text-5xl lg:text-[55px] leading-tight text-white">
                    Checkout Product
                </h1>
                <p class="text-pink-100 text-lg">Complete your purchase securely</p>
            </div>
        </div>
        <div class="w-full h-full absolute top-0 bg-[#510825] z-0"></div>
    </header>

    @if ($errors->any())
        <div class="container max-w-[1130px] mx-auto px-4 -mt-16 mb-8 relative z-10">
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

    <!-- Main Checkout Section -->
    <section id="checkout" class="container max-w-[1130px] mx-auto mb-[102px] relative -top-[70px] px-4">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Product Info -->
            <div class="flex flex-col gap-6 w-full lg:w-[700px] shrink-0">
                <div
                    class="w-full h-[250px] sm:h-[400px] md:h-[500px] flex shrink-0 rounded-[20px] overflow-hidden shadow-2xl">
                    <img src="{{ Storage::url($product->cover) }}" class="w-full h-full object-cover"
                        alt="{{ $product->name }}">
                </div>

                <div class="flex flex-col p-6 gap-5 bg-gradient-to-br from-pink-600 to-pink-700 rounded-[20px] shadow-xl">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <p
                                    class="bg-pink-500/30 backdrop-blur font-semibold text-xs text-white rounded-[6px] px-3 py-1.5 w-fit mb-3">
                                    {{ $product->category->name }}
                                </p>
                                <h2 class="font-semibold text-2xl text-white mb-4">{{ $product->name }}</h2>
                            </div>
                            <p class="font-semibold text-3xl sm:text-4xl text-white shrink-0">
                                Rp {{ number_format($product->price) }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-pink-400/30">
                            <div class="w-12 h-12 rounded-full flex shrink-0 overflow-hidden border-2 border-pink-300">
                                <img src="{{ Storage::url($product->creator->avatar) }}" class="w-full h-full object-cover"
                                    alt="{{ $product->creator->name }}">
                            </div>
                            <div class="flex flex-col">
                                <p class="text-pink-100 text-xs">Created by</p>
                                <p class="font-semibold text-white">{{ $product->creator->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="flex flex-col w-full lg:w-[366px] gap-6 flex-nowrap">

                <!-- Transfer Information -->
                <div class="p-[2px] bg-gradient-to-br from-pink-400 to-pink-500 rounded-[20px] flex w-full h-fit shadow-xl">
                    <div class="w-full p-6 bg-white rounded-[20px] flex flex-col gap-6">
                        <h3 class="font-semibold text-xl text-gray-800">Transfer Details</h3>

                        <div class="flex flex-col gap-4">
                            <!-- Bank Name -->
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-medium text-gray-600">Bank Name</label>
                                <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-lg border border-pink-200">
                                    <img src="{{ asset('images/icons/bank.svg') }}" class="w-5 h-5" alt="icon">
                                    <span class="font-semibold text-gray-800">{{ $product->creator->bank_name }}</span>
                                </div>
                            </div>

                            <!-- Account Name -->
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-medium text-gray-600">Account Name</label>
                                <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-lg border border-pink-200">
                                    <img src="{{ asset('images/icons/user-square.svg') }}" class="w-5 h-5" alt="icon">
                                    <span class="font-semibold text-gray-800">{{ $product->creator->bank_account }}</span>
                                </div>
                            </div>

                            <!-- Account Number -->
                            <div class="flex flex-col gap-2">
                                <label class="text-sm font-medium text-gray-600">Account Number</label>
                                <div class="flex items-center gap-3 p-4 bg-pink-50 rounded-lg border border-pink-200">
                                    <img src="{{ asset('images/icons/card.svg') }}" class="w-5 h-5" alt="icon">
                                    <span
                                        class="font-semibold text-gray-800">{{ $product->creator->bank_account_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Proof Upload -->
                <div class="p-[2px] bg-gradient-to-br from-pink-400 to-pink-500 rounded-[20px] flex w-full h-fit shadow-xl">
                    <div class="w-full p-6 bg-white rounded-[20px] flex flex-col gap-6">
                        <h3 class="font-semibold text-xl text-gray-800">Payment Confirmation</h3>
                       
                        <form method="POST" action="{{ route('front.checkout.store', $product->slug) }}"
                            enctype="multipart/form-data" class="flex flex-col gap-4">
                            @csrf

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-sm text-blue-700 leading-relaxed">
                                    Please upload your payment proof. We will verify and confirm your purchase as soon as
                                    possible.
                                </p>
                            </div>

                            <div class="flex flex-col gap-3">
                                <label class="text-sm font-medium text-gray-600">Upload Payment Proof</label>

                                <button type="button"
                                    class="flex gap-2 items-center justify-center p-4 border-2 border-dashed border-pink-300 rounded-lg hover:border-pink-400 hover:bg-pink-50 transition-all duration-300"
                                    onclick="document.getElementById('proof').click()">
                                    <img src="{{ asset('images/icons/document-upload.svg') }}" class="w-5 h-5"
                                        alt="icon">
                                    <span class="font-medium text-gray-700">Choose File</span>
                                </button>

                                <input type="file" name="proof" id="proof" class="hidden" onchange="previewFile()"
                                    accept="image/*" required>

                                <div
                                    class="relative rounded-lg overflow-hidden bg-pink-50 border border-pink-200 h-[120px]">
                                    <div class="relative file-preview z-10 w-full h-full hidden">
                                        <img src="{{ asset('images/icons/check.svg') }}"
                                            class="check-icon absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 w-12 h-12 z-20"
                                            alt="icon">
                                        <img src="" class="thumbnail-proof w-full h-full object-cover"
                                            alt="thumbnail">
                                    </div>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                                        <img src="{{ asset('images/icons/gallery.svg') }}" class="w-8 h-8 opacity-40"
                                            alt="icon">
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

            </div>
        </div>
    </section>

    <x-footer />

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
    </script>

@endsection

@push('after-script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function previewFile() {
            var preview = document.querySelector('.file-preview');
            var fileInput = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                var img = preview.querySelector('.thumbnail-proof'); // Get the thumbnail image element
                img.src = reader.result; // Update src attribute with the uploaded file
                preview.classList.remove('hidden'); // Remove the 'hidden' class to display the preview
            }

            if (fileInput) {
                reader.readAsDataURL(fileInput);
            } else {
                preview.classList.add('hidden'); // Hide preview if no file selected
            }
        }
    </script>
    <script>
        function copyTextFunc(id) {
            var copyText = document.getElementById(id);

            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            document.execCommand("copy");

            alert("Copied the text: " + copyText.value);
        }
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
