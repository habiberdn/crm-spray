<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {

        $cart = session()->get('cart', []);

        // Jika user login, ambil cart dari database dan sync dengan session
        if (auth()->check()) {
            $userId = auth()->id();
            // Ambil cart dari database
            $dbCarts = Cart::where('user_id', $userId)->get();
            // Sync database cart ke session
            foreach ($dbCarts as $dbCart) {
                $productId = $dbCart->product_id; // Pastikan column ini ada

                // Update atau tambahkan ke session cart
                if (!isset($cart[$productId])) {
                    // Ambil detail product dari database
                    $product = Product::find($productId);

                    if ($product) {
                        $cart[$productId] = [
                            'user_id' => $userId,
                            'name' => $product->name,
                            'cover' => $product->cover,
                            'discount_price' => $product->discount_price,
                            'quantity' => $dbCart->quantity
                        ];
                    }
                } else {
                    // Update quantity dari database
                    $cart[$productId]['quantity'] = $dbCart->quantity;
                }
            }

            // Simpan kembali ke session
            session()->put('cart', $cart);
        }

        $total = $this->calculateTotal($cart);

        return view('components.navbar', compact('cart', 'total'));
    }

    /**
     * Get cart page for checkout (display all items in cart)
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
       
        if (empty($cart)) {
            return redirect()->route('front.index')->with('error', 'Keranjang Anda kosong');
        }

        $total = $this->calculateTotal($cart);

        return view('front.cart', compact('cart', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        
        try {
            $cart = session()->get('cart', []);

            // Calculate discount price
            $price = $product->price;
            if (isset($product->diskon)) {
                if ($product->diskon->type == 'percentage') {
                    $price = $product->price - ($product->price * $product->diskon->value / 100);
                } elseif ($product->diskon->type == 'fixed') {
                    $price = $product->price - $product->diskon->value;
                }
            }

            $existing = Cart::where('user_id', auth()->id())
                ->where('name', $product->name)
                ->first();

            if ($existing) {
                // Update database quantity
                $existing->increment('quantity');

                // Update session quantity
                if (isset($cart[$product->id])) {
                    $cart[$product->id]['quantity']++;
                }
            } else {
                // Data baru untuk cart
                $data = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "discount_price" => $price,
                    "original_price" => $product->price,
                    "cover" => $product->cover,
                    "user_id" => auth()->id()
                ];

                // SIMPAN KE DATABASE
                Cart::create($data);

                // SIMPAN KE SESSION
                $cart[$product->id] = $data;
            }

            // Update session cart
            session()->put('cart', $cart);

            // JSON Response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil ditambahkan ke keranjang!',
                    'cart_count' => $this->getCartCount()
                ]);
            }

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            Log::error('Cart Add Error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan produk ke keranjang'
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menambahkan produk ke keranjang');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer',
                'change' => 'required|integer'
            ]);

            $productId = $request->product_id;
            $change = $request->change;

            // Jika user login, update di database
            if (auth()->check()) {
                $cartItem = Cart::where('user_id', auth()->id())
                    ->where('id', $productId)
                    ->first();

                if (!$cartItem) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Produk tidak ditemukan di keranjang'
                    ], 404);
                }

                // Hitung quantity baru
                $newQuantity = $cartItem->quantity + $change;

                // Jika quantity <= 0, hapus item
                if ($newQuantity <= 0) {
                    $cartItem->delete();

                    // Update session juga
                    $cart = session()->get('cart', []);
                    unset($cart[$productId]);
                    session()->put('cart', $cart);

                    return response()->json([
                        'success' => true,
                        'message' => 'Produk dihapus dari keranjang',
                        'cart_count' => $this->getCartCount(),
                        'removed' => true
                    ]);
                }

                // Batasi max quantity
                if ($newQuantity > 99) {
                    $newQuantity = 99;
                }

                // Update quantity
                $cartItem->update(['quantity' => $newQuantity]);

                // Sync dengan session
                $cart = session()->get('cart', []);
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] = $newQuantity;
                    session()->put('cart', $cart);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Keranjang berhasil diperbarui',
                    'cart_count' => $this->getCartCount(),
                    'cart_total' => $this->calculateTotal()
                ]);
            }

            // Jika guest user (tidak login), gunakan session
            $cart = session()->get('cart', []);

            if (!isset($cart[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan di keranjang'
                ], 404);
            }

            // Update quantity
            $cart[$productId]['quantity'] += $change;

            // Hapus jika quantity <= 0
            if ($cart[$productId]['quantity'] <= 0) {
                unset($cart[$productId]);
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Produk dihapus dari keranjang',
                    'cart_count' => $this->getCartCount(),
                    'removed' => true
                ]);
            }

            // Batasi max quantity
            if ($cart[$productId]['quantity'] > 99) {
                $cart[$productId]['quantity'] = 99;
            }

            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil diperbarui',
                'cart_count' => $this->getCartCount(),
                'cart_total' => $this->calculateTotal()
            ]);
        } catch (\Exception $e) {
            Log::error('Cart Update Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    // Helper method untuk calculate total
    private function calculateTotal()
    {
        if (auth()->check()) {
            $carts = Cart::where('user_id', auth()->id())->get();
            return $carts->sum(function ($item) {
                return $item->discount_price * $item->quantity;
            });
        }

        $cart = session()->get('cart', []);
        return collect($cart)->sum(function ($item) {
            return $item['discount_price'] * $item['quantity'];
        });
    }

    // Helper method untuk get cart count
    private function getCartCount()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->sum('quantity');
        }

        $cart = session()->get('cart', []);
        return is_array($cart) ? array_sum(array_column($cart, 'quantity')) : 0;
    }

    public function remove(Request $request)
{
    try {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $productId = $request->product_id;

        // Jika user login, hapus dari database
        if (auth()->check()) {
            $deleted = Cart::where('id', $productId)
                ->delete();
            
            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan di keranjang database'
                ], 404);
            }
        }

        // Hapus dari session
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari keranjang',
                'cart_count' => $this->getCartCount(),
                'cart_total' => $this->calculateTotal($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan di keranjang session'
        ], 404);
        
    } catch (\Exception $e) {
        Log::error('Cart Remove Error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus produk: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan!');
    }

    /**
     * Get cart count
     */


    /**
     * Get cart data (for API/AJAX)
     */
    public function getCartData()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'cart_count' => $this->getCartCount(),
            'cart_total' => $this->calculateTotal($cart)
        ]);
    }
}
