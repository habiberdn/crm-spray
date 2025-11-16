<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
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
                    <h3 class="text-indigo-950 font-bold text-2xl">My Orders</h3>
                </div>

                @forelse($my_orders as $order)
                    <div class="item-product flex flex-row justify-between items-center p-5 border border-gray-200 rounded-xl hover:shadow-md transition-all">
                        <div class="flex flex-row items-center gap-x-5">
                            <img src="{{ Storage::url($order->product->cover) }}"
                                class="rounded-2xl h-[100px] w-auto" alt="{{ $order->product->name }}">
                            <div>
                                <h3 class="text-indigo-950 font-bold text-xl">{{ $order->product->name }}</h3>
                                <p class="text-slate-500 text-sm">{{ $order->product->category->name }}</p>
                                <p class="text-slate-600 text-sm mt-1">
                                    <span class="font-semibold">Qty:</span> {{ $order->quantity }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <p class="text-slate-500 text-sm">Total Price:</p>
                            <p class="text-indigo-950 font-bold text-xl">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>
                            @if($order->quantity > 1)
                                <p class="text-slate-500 text-xs mt-1">
                                    (Rp {{ number_format($order->total_price / $order->quantity, 0, ',', '.') }} / item)
                                </p>
                            @endif
                        </div>

                        <div>
                            <p class="text-slate-500 text-sm">Status:</p>
                            @if ($order->is_paid)
                                <span class="py-1 px-3 rounded-full bg-green-500 text-white font-bold text-sm">
                                    SUCCESS
                                </span>
                            @else
                                <span class="py-1 px-3 rounded-full bg-orange-500 text-white font-bold text-sm">
                                    PENDING
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-row gap-x-3">
                            <a href="{{ route('admin.product_orders.show', $order) }}"
                                class="rounded-full font-bold py-3 px-5 bg-indigo-500 text-white hover:bg-indigo-600 transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="text-gray-500 text-lg">Belum ada barang yang dibeli</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>