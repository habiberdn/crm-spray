<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);
        
        return view('front.cart', compact('cart', 'total'));
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
        
        return view('front.checkout-cart', compact('cart', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        try {
            $cart = session()->get('cart', []);

            // Check if product has discount
            $price = $product->price;
            if (isset($product->diskon)) {
                if ($product->diskon->type == 'percentage') {
                    $price = $product->price - ($product->price * $product->diskon->value / 100);
                } elseif ($product->diskon->type == 'fixed') {
                    $price = $product->price - $product->diskon->value;
                }
            }

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
            } else {
                $cart[$product->id] = [
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "quantity" => 1,
                    "price" => $price, // Use discounted price
                    "original_price" => $product->price, // Keep original price
                    "image" => $product->cover // Use 'cover' field based on your model
                ];
            }

            session()->put('cart', $cart);

            // Return JSON for AJAX requests
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

    /**
     * Update cart quantity (AJAX)
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer',
                'change' => 'required|integer'
            ]);

            $cart = session()->get('cart', []);
            $productId = $request->product_id;

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $request->change;

                // Remove item if quantity is 0 or less
                if ($cart[$productId]['quantity'] <= 0) {
                    unset($cart[$productId]);
                } else {
                    // Optional: Set maximum quantity limit
                    if ($cart[$productId]['quantity'] > 99) {
                        $cart[$productId]['quantity'] = 99;
                    }
                }

                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Keranjang berhasil diperbarui',
                    'cart_count' => $this->getCartCount(),
                    'cart_total' => $this->calculateTotal($cart)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Cart Update Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui keranjang'
            ], 500);
        }
    }

    /**
     * Remove product from cart (AJAX)
     */
    public function remove(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer'
            ]);

            $cart = session()->get('cart', []);
            $productId = $request->product_id;

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
                'message' => 'Produk tidak ditemukan di keranjang'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Cart Remove Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk dari keranjang'
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
    private function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Calculate cart total
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

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