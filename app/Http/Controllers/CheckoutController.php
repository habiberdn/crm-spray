<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    //
    public function checkout(Product $product){
        return view('front.checkout', [
            'product' => $product
        ]);
    }

    
    public function store(Request $request, Product $product){
        // validasi agar pembeli tidak membeli produknya sendiri
       
        if($product->creator_id === Auth::id()){
            $error = ValidationException::withMessages([
                'system_error' => ['Do not buy your own product'],
            ]);
            throw $error;
        }

        $validated = $request->validate([
            'proof' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if($request->hasFile('proof')){
            $proofPath = $request->file('proof')->store('payment_proofs', 'public');
            $validated['proof'] = $proofPath;
        }

        $data = [
            'total_price' => $product->price,
            'is_paid' => false,
            'buyer_id' => Auth::id(),
            'creator_id' => $product->creator_id,
            'product_id' => $product->id,
            'proof' => $validated['proof'],
        ];

        DB::beginTransaction();

        try{
            
            $newOrder = ProductOrder::firstOrCreate($data);

            DB::commit();

            return redirect()->route('admin.product_orders.transactions')->with('success', 'Success checkout successfuly!');
        }
        catch(\Exception $e){
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);

            throw $error;
        }
    }

      public function storeCart(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('front.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        DB::beginTransaction();

        try {
            $orders = [];

            foreach ($cart as $productId => $item) {
                $productOrder = ProductOrder::create([
                    'product_id' => $productId,
                    'user_id' => auth()->id(),
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total_amount' => $item['price'] * $item['quantity'],
                    'is_paid' => false,
                ]);

                $orders[] = $productOrder;
            }

            // Clear cart after successful order
            session()->forget('cart');

            DB::commit();

            // Redirect to first order (or you can create a summary page)
            return redirect()->route('admin.product_orders.show', $orders[0])
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran untuk ' . count($orders) . ' produk.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart Checkout Error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.')
                ->withInput();
        }
    }
}