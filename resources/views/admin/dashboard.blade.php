<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Creator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg flex flex-col gap-y-5">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li class="py-5 bg-red-500 text-white font-bold">
                                    {{$error}}
                                </li>
                            @endforeach    
                        </ul>
                    </div>
                @endif

                <div class="flex flex-row justify-between items-center mb-5">
                    <h3 class="text-indigo-950 font-bold text-2xl">Overview</h3>
                </div>

                <!-- Main Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Products -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-md">
                        <p class="text-blue-600 text-sm font-medium mb-2">Total Product</p>
                        <p class="text-indigo-950 font-bold text-3xl">{{count($my_products)}}</p>
                        <p class="text-blue-500 text-xs mt-2">
                            {{$products_with_discount}} produk dengan diskon
                        </p>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-md">
                        <p class="text-purple-600 text-sm font-medium mb-2">Total Pesanan</p>
                        <p class="text-indigo-950 font-bold text-3xl">{{$total_order_success}}</p>
                        <p class="text-purple-500 text-xs mt-2">Pesanan berhasil</p>
                    </div>

                    <!-- Actual Revenue -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-md">
                        <p class="text-green-600 text-sm font-medium mb-2">Pendapatan Aktual</p>
                        <p class="text-indigo-950 font-bold text-3xl">Rp {{number_format($my_revenue)}}</p>
                        <p class="text-green-500 text-xs mt-2">Setelah diskon</p>
                    </div>

                    <!-- Total Discount Given -->
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow-md">
                        <p class="text-red-600 text-sm font-medium mb-2">Total Diskon Diberikan</p>
                        <p class="text-indigo-950 font-bold text-3xl">Rp {{number_format($total_discount_given)}}</p>
                        <p class="text-red-500 text-xs mt-2">Potongan harga</p>
                    </div>
                </div>

                <!-- Products List with Discount Info -->
                <div class="mt-8">
                    <h4 class="text-indigo-950 font-bold text-xl mb-4">Daftar Produk & Diskon</h4>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Produk
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Asli
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Diskon
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Jual
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($my_products as $product)
                                    @php
                                        $hasDiscount = $product->diskon !== null;
                                        $finalPrice = $product->price;
                                        $discountAmount = 0;
                                        
                                        if ($hasDiscount) {
                                            if ($product->diskon->type == 'percentage') {
                                                $discountAmount = ($product->price * $product->diskon->value / 100);
                                                $finalPrice = $product->price - $discountAmount;
                                                $discountLabel = $product->diskon->value . '%';
                                            } else {
                                                $discountAmount = $product->diskon->value;
                                                $finalPrice = $product->price - $discountAmount;
                                                $discountLabel = 'Rp ' . number_format($discountAmount);
                                            }
                                        }
                                    @endphp
                                    
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img src="{{ Storage::url($product->cover) }}" 
                                                     class="w-12 h-12 rounded-lg object-cover" 
                                                     alt="{{ $product->name }}">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ Str::limit($product->name, 30) }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $product->category->name ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm {{ $hasDiscount ? 'line-through text-gray-400' : 'text-gray-900 font-semibold' }}">
                                                Rp {{ number_format($product->price) }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($hasDiscount)
                                                <div class="flex flex-col gap-1">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        -{{ $discountLabel }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        (Rp {{ number_format($discountAmount) }})
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold {{ $hasDiscount ? 'text-green-600' : 'text-gray-900' }}">
                                                Rp {{ number_format($finalPrice) }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($hasDiscount)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Ada Diskon
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Harga Normal
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                                <p class="font-medium">Belum ada produk</p>
                                                <p class="text-sm">Mulai tambahkan produk untuk ditampilkan di sini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Revenue Summary -->
                @if($total_order_success > 0)
                <div class="mt-8 bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-100">
                    <h4 class="text-indigo-950 font-bold text-lg mb-4">Ringkasan Revenue</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Potensi Revenue (tanpa diskon)</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($potential_revenue) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Diskon Diberikan</p>
                            <p class="text-xl font-bold text-red-600">- Rp {{ number_format($total_discount_given) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Revenue Aktual</p>
                            <p class="text-xl font-bold text-green-600">Rp {{ number_format($my_revenue) }}</p>
                        </div>
                    </div>
                    
                    @php
                        $discountPercentage = $potential_revenue > 0 
                            ? ($total_discount_given / $potential_revenue) * 100 
                            : 0;
                    @endphp
                    
                    <div class="mt-4 pt-4 border-t border-indigo-200">
                        <p class="text-sm text-gray-600">Persentase Diskon Total</p>
                        <div class="flex items-center gap-3 mt-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-red-500 to-red-600 h-full rounded-full transition-all duration-500" 
                                     style="width: {{ min($discountPercentage, 100) }}%">
                                    </div>
                            </div>
                            <span class="text-lg font-bold text-red-600">{{ number_format($discountPercentage, 1) }}%</span>
                        </div>
                    </div>  
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>