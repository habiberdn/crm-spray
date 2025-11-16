<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg flex flex-col gap-y-5">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="py-5 bg-red-500 text-white font-bold">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex flex-row justify-between items-center mb-5">
                    <h3 class="text-indigo-950 font-bold text-2xl">My Transactions</h3>
                    <p class="text-slate-500 text-sm">Transaksi produk yang Anda Beli</p>
                </div>

                @forelse($my_transactions as $transaction)
                    <div class="item-product flex flex-row justify-between items-center p-5 border border-gray-200 rounded-xl hover:shadow-md transition-all">
                        <!-- Product Info -->
                        <div class="flex flex-row items-center gap-x-5">
                            <img src="{{ Storage::url($transaction->product->cover) }}"
                                class="rounded-2xl h-[100px] w-auto object-cover" 
                                alt="{{ $transaction->product->name }}">
                            <div>
                                <h3 class="text-indigo-950 font-bold text-xl">{{ $transaction->product->name }}</h3>
                                <p class="text-slate-500 text-sm">{{ $transaction->product->category->name }}</p>
                                
                                <!-- Buyer Info -->
                                <div class="flex items-center gap-2 mt-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <p class="text-slate-600 text-sm font-medium">
                                        Pembeli: {{ $transaction->buyer->name }}
                                    </p>
                                </div>

                                <!-- Buyer Address -->
                                <div class="flex items-start gap-2 mt-1">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-slate-600 text-sm max-w-xs">
                                        {{ auth()->user()->alamat ?? 'Alamat tidak tersedia' }}
                                    </p>
                                </div>

                                <!-- Quantity Info -->
                                <p class="text-slate-600 text-sm mt-1">
                                    <span class="font-semibold">Qty:</span> {{ $transaction->quantity }} pcs
                                </p>

                                <!-- Order Date -->
                                <p class="text-slate-500 text-xs mt-1">
                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Price Info -->
                        <div class="text-right">
                            <p class="text-slate-500 text-sm mb-1">Total Price:</p>
                            <p class="text-indigo-950 font-bold text-2xl">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </p>
                            
                            @if($transaction->quantity > 1)
                                <p class="text-slate-500 text-xs mt-1">
                                    (Rp {{ number_format($transaction->total_price / $transaction->quantity, 0, ',', '.') }} / item)
                                </p>
                            @endif
                        </div>

                        <!-- Status -->
                        <div class="text-center">
                            <p class="text-slate-500 text-sm mb-2">Status:</p>
                            @if ($transaction->is_paid)
                                <span class="py-2 px-4 rounded-full bg-green-500 text-white font-bold text-sm inline-block">
                                    ✓ SUCCESS
                                </span>
                            @else
                                <span class="py-2 px-4 rounded-full bg-orange-500 text-white font-bold text-sm inline-block">
                                    ⏳ PENDING
                                </span>
                            @endif
                        </div>

                        <!-- Action -->
                        <div class="flex flex-col gap-y-2">
                            <a href="{{ route('admin.product_orders.transactions.details', $transaction) }}"
                                class="rounded-full font-bold py-3 px-5 bg-indigo-500 text-white hover:bg-indigo-600 transition-all text-center">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg font-semibold mb-2">Belum ada transaksi tersedia</p>
                        <p class="text-gray-400 text-sm">Transaksi dari pembeli akan muncul di sini</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>