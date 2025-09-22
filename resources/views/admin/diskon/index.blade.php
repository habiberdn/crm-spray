<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Diskon Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200">
                    <div class="p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Kelola Diskon Produk</h3>
                            <p class="mt-1 text-sm text-gray-500">Berikan diskon untuk produk tertentu dan kelola promosi</p>
                        </div>
                        <button id="addDiscountBtn" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Diskon Produk
                        </button>
                    </div>
                </div>

                <!-- Filter and Search -->
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Cari nama produk..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="flex gap-2 ">
                            <select class="text-sm  block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option>Status</option>
                                <option>Aktif</option>
                                <option>Tidak Aktif</option>
                                <option>Kedaluwarsa</option>
                            </select>
                            <select class="text-sm block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option>Kategori</option>
                                <option>Bantal</option>
                                <option>Seprai</option>
                                <option>Lainnya</option>
                            </select>
                            <select class="text-sm block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option>Tipe</option>
                                <option>Persentase</option>
                                <option>Nominal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Product Discount List -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Asli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Diskon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Diskon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Setelah Diskon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berlaku Hingga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Sample Data Rows -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-lg object-cover" src="https://via.placeholder.com/48/E5E7EB/6B7280?text=IMG" alt="Produk">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Bantal Empuk Premium</div>
                                            <div class="text-sm text-gray-500">SKU: BNT001</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp 150.000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Persentase</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">20%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">Rp 120.000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">31 Des 2025</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <button class="text-indigo-600 hover:text-indigo-900" title="Edit Diskon">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900" title="Hapus Diskon">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                          
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Add/Edit Product Discount Modal -->
            <div id="discountModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                    
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                        <form id="discountForm">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Diskon Produk</h3>
                                        
                                        <div class="space-y-4">
                                            <!-- Product Selection -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                                                <select name="product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                    <option value="">-- Pilih Produk --</option>
                                                    <option value="1">Bantal Empuk Premium - Rp 150.000</option>
                                                    <option value="2">Seprai Katun Organik - Rp 300.000</option>
                                                    <option value="3">Guling Microfiber - Rp 85.000</option>
                                                    <option value="4">Selimut Tebal Winter - Rp 250.000</option>
                                                    <option value="5">Set Sprei King Size - Rp 450.000</option>
                                                </select>
                                                <p class="mt-1 text-sm text-gray-500">Pilih produk yang akan diberikan diskon</p>
                                            </div>

                                            <!-- Product Preview (will show when product is selected) -->
                                            <div id="productPreview" class="hidden p-4 bg-gray-50 rounded-lg border">
                                                <div class="flex items-center space-x-4">
                                                    <img id="previewImage" class="h-16 w-16 rounded-lg object-cover" src="" alt="Preview">
                                                    <div>
                                                        <h4 id="previewName" class="font-medium text-gray-900"></h4>
                                                        <p id="previewPrice" class="text-sm text-gray-500"></p>
                                                        <p id="previewSKU" class="text-sm text-gray-400"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tipe Diskon</label>
                                                    <select name="discount_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                        <option value="">Pilih tipe diskon</option>
                                                        <option value="percentage">Persentase (%)</option>
                                                        <option value="fixed">Nominal (Rp)</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Nilai Diskon</label>
                                                    <input type="number" name="discount_value" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 20 atau 50000" required>
                                                    <p class="mt-1 text-xs text-gray-500">Masukkan angka saja (tanpa % atau Rp)</p>
                                                </div>
                                            </div>

                                            <!-- Discount Preview -->
                                            <div id="discountPreview" class="hidden p-4 bg-blue-50 rounded-lg border border-blue-200">
                                                <h4 class="font-medium text-blue-900 mb-2">Preview Diskon:</h4>
                                                <div class="space-y-1 text-sm">
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Harga Asli:</span>
                                                        <span id="originalPrice" class="font-medium">-</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Diskon:</span>
                                                        <span id="discountAmount" class="font-medium text-red-600">-</span>
                                                    </div>
                                                    <div class="flex justify-between border-t pt-1">
                                                        <span class="text-gray-900 font-medium">Harga Setelah Diskon:</span>
                                                        <span id="finalPrice" class="font-bold text-green-600">-</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Penghematan:</span>
                                                        <span id="savings" class="font-medium text-blue-600">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                                    <input type="date" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                                                    <input type="date" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Diskon Produk
                                </button>
                                <button type="button" id="cancelModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Product data for preview
        const products = {
            1: { name: 'Bantal Empuk Premium', price: 150000, sku: 'BNT001', image: 'https://via.placeholder.com/64/E5E7EB/6B7280?text=BNT' },
            2: { name: 'Seprai Katun Organik', price: 300000, sku: 'SPR002', image: 'https://via.placeholder.com/64/E5E7EB/6B7280?text=SPR' },
            3: { name: 'Guling Microfiber', price: 85000, sku: 'GUL003', image: 'https://via.placeholder.com/64/E5E7EB/6B7280?text=GUL' },
            4: { name: 'Selimut Tebal Winter', price: 250000, sku: 'SLM004', image: 'https://via.placeholder.com/64/E5E7EB/6B7280?text=SLM' },
            5: { name: 'Set Sprei King Size', price: 450000, sku: 'SET005', image: 'https://via.placeholder.com/64/E5E7EB/6B7280?text=SET' }
        };

        // Modal functionality
        const addDiscountBtn = document.getElementById('addDiscountBtn');
        const discountModal = document.getElementById('discountModal');
        const cancelModal = document.getElementById('cancelModal');
        const discountForm = document.getElementById('discountForm');

        addDiscountBtn.addEventListener('click', function() {
            discountModal.classList.remove('hidden');
        });

        cancelModal.addEventListener('click', function() {
            discountModal.classList.add('hidden');
            discountForm.reset();
            hidePreview();
        });

        // Close modal when clicking outside
        discountModal.addEventListener('click', function(e) {
            if (e.target === discountModal) {
                discountModal.classList.add('hidden');
                discountForm.reset();
                hidePreview();
            }
        });

        // Product selection and preview
        document.querySelector('select[name="product_id"]').addEventListener('change', function() {
            const productId = this.value;
            const preview = document.getElementById('productPreview');
            
            if (productId && products[productId]) {
                const product = products[productId];
                
                document.getElementById('previewImage').src = product.image;
                document.getElementById('previewName').textContent = product.name;
                document.getElementById('previewPrice').textContent = `Rp ${product.price.toLocaleString('id-ID')}`;
                document.getElementById('previewSKU').textContent = `SKU: ${product.sku}`;
                
                preview.classList.remove('hidden');
                updateDiscountPreview();
            } else {
                hidePreview();
            }
        });

        // Discount calculation
        function updateDiscountPreview() {
            const productId = document.querySelector('select[name="product_id"]').value;
            const discountType = document.querySelector('select[name="discount_type"]').value;
            const discountValue = parseFloat(document.querySelector('input[name="discount_value"]').value) || 0;
            
            if (!productId || !discountType || !discountValue) {
                document.getElementById('discountPreview').classList.add('hidden');
                return;
            }
            
            const product = products[productId];
            const originalPrice = product.price;
            let discountAmount = 0;
            let finalPrice = originalPrice;
            
            if (discountType === 'percentage') {
                discountAmount = (originalPrice * discountValue) / 100;
                finalPrice = originalPrice - discountAmount;
            } else if (discountType === 'fixed') {
                discountAmount = discountValue;
                finalPrice = originalPrice - discountAmount;
            }
            
            // Prevent negative prices
            if (finalPrice < 0) finalPrice = 0;
            
            // Update preview
            document.getElementById('originalPrice').textContent = `Rp ${originalPrice.toLocaleString('id-ID')}`;
            document.getElementById('discountAmount').textContent = discountType === 'percentage' 
                ? `-${discountValue}% (Rp ${discountAmount.toLocaleString('id-ID')})` 
                : `-Rp ${discountAmount.toLocaleString('id-ID')}`;
            document.getElementById('finalPrice').textContent = `Rp ${finalPrice.toLocaleString('id-ID')}`;
            document.getElementById('savings').textContent = `${((discountAmount/originalPrice)*100).toFixed(1)}%`;
            
            document.getElementById('discountPreview').classList.remove('hidden');
        }

        // Update preview when discount values change
        document.querySelector('select[name="discount_type"]').addEventListener('change', updateDiscountPreview);
        document.querySelector('input[name="discount_value"]').addEventListener('input', updateDiscountPreview);

        function hidePreview() {
            document.getElementById('productPreview').classList.add('hidden');
            document.getElementById('discountPreview').classList.add('hidden');
        }

        // Form submission
        discountForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const productId = formData.get('product_id');
            const discountType = formData.get('discount_type');
            const discountValue = formData.get('discount_value');
            
            if (!productId || !discountType || !discountValue) {
                alert('Mohon lengkapi semua field yang required');
                return;
            }
            
            // Here you would normally send the data to your Laravel backend
            console.log('Form data:', Object.fromEntries(formData));
            
            alert('Diskon produk berhasil disimpan!');
            discountModal.classList.add('hidden');
            discountForm.reset();
            hidePreview();
            
            // Optionally reload the page or update the table dynamically
            // location.reload();
        });

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="start_date"]').min = today;
        document.querySelector('input[name="end_date"]').min = today;

        // Update end date minimum when start date changes
        document.querySelector('input[name="start_date"]').addEventListener('change', function() {
            document.querySelector('input[name="end_date"]').min = this.value;
        });
    </script>
</x-app-layout>