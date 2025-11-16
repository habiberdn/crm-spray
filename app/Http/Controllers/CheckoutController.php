<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use Illuminate\Support\Facades\Storage;


class CheckoutController extends Controller
{
    //
    public function checkout(Product $product){
        return view('front.checkout', [
            'product' => $product
        ]);
    }
    
   public function store(Request $request, Product $product = null)
    {
        // Validasi bukti pembayaran
        $validated = $request->validate([
            'proof' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Upload bukti pembayaran
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('payment_proofs', 'public');
            $validated['proof'] = $proofPath;
        }

        // Tentukan apakah ini cart checkout atau single product checkout
        $isCartCheckout = is_null($product);

        DB::beginTransaction();

        try {
            $ordersCreated = [];

            if ($isCartCheckout) {
                // ===== CART CHECKOUT =====
                
                // Ambil cart dari database atau session
                if (auth()->check()) {
                    $dbCarts = Cart::where('user_id', auth()->id())->get();
                  
                    if ($dbCarts->isEmpty()) {
                        throw ValidationException::withMessages([
                            'system_error' => ['Keranjang belanja Anda kosong'],
                        ]);
                    }

                    $cart = [];
                    foreach ($dbCarts as $dbCart) {
                        $productItem = Product::find($dbCart->id);
                        if ($productItem) {
                            $cart[$dbCart->id] = [
                                'name' => $productItem->name,
                                'cover' => $productItem->cover,
                                'discount_price' => $productItem->discount_price ?? $productItem->price,
                                'quantity' => $dbCart->quantity,
                                'creator_id' => $productItem->creator_id,
                            ];
                        }
                    }
                } else {
                    $cart = session()->get('cart', []);

                }
                if (empty($cart)) {
                    throw ValidationException::withMessages([
                        'system_error' => ['Keranjang belanja Anda kosong'],
                    ]);
                }

                // Validasi tidak membeli produk sendiri
                foreach ($cart as $productId => $item) {
                    if (isset($item['creator_id']) && $item['creator_id'] === Auth::id()) {
                        throw ValidationException::withMessages([
                            'system_error' => ['Anda tidak dapat membeli produk Anda sendiri: ' . $item['name']],
                        ]);
                    }
                }

                // Loop untuk setiap produk di cart
                foreach ($cart as $productId => $item) {
                    $productItem = Product::find($productId);
                    
                    if (!$productItem) {
                        continue;
                    }

                    $totalPrice = $item['discount_price'] * $item['quantity'];

                    $orderData = [
                        'total_price' => $totalPrice,
                        'quantity' => $item['quantity'],
                        'is_paid' => false,
                        'buyer_id' => Auth::id(),
                        'creator_id' => $productItem->creator_id,
                        'product_id' => $productItem->id,
                        'proof' => $validated['proof'],
                    ];

                    $newOrder = ProductOrder::create($orderData);
                    $ordersCreated[] = $newOrder->id;
                }

                // Hapus cart setelah checkout berhasil
                if (auth()->check()) {
                    Cart::where('user_id', auth()->id())->delete();
                }
                session()->forget('cart');

                DB::commit();

                return redirect()->route('admin.product_orders.transactions')
                    ->with('success', 'Checkout berhasil! ' . count($ordersCreated) . ' pesanan telah dibuat.');

            } else {
                // ===== SINGLE PRODUCT CHECKOUT =====
                
                // Validasi tidak membeli produk sendiri
                if ($product->creator_id === Auth::id()) {
                    throw ValidationException::withMessages([
                        'system_error' => ['Anda tidak dapat membeli produk Anda sendiri'],
                    ]);
                }

                $data = [
                    'total_price' => $product->price,
                    'quantity' => 1,
                    'is_paid' => false,
                    'buyer_id' => Auth::id(),
                    'creator_id' => $product->creator_id,
                    'product_id' => $product->id,
                    'proof' => $validated['proof'],
                ];

                $newOrder = ProductOrder::create($data);

                DB::commit();

                return redirect()->route('admin.product_orders.transactions')
                    ->with('success', 'Checkout berhasil!');
            }

        } catch (ValidationException $e) {
            DB::rollBack();
            
            // Hapus file proof jika ada error
            if (isset($validated['proof']) && Storage::disk('public')->exists($validated['proof'])) {
                Storage::disk('public')->delete($validated['proof']);
            }
            
            throw $e;

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file proof jika ada error
            if (isset($validated['proof']) && Storage::disk('public')->exists($validated['proof'])) {
                Storage::disk('public')->delete($validated['proof']);
            }

            Log::error('Checkout Error: ' . $e->getMessage());

            throw ValidationException::withMessages([
                'system_error' => ['System error! ' . $e->getMessage()],
            ]);
        }
    }
}