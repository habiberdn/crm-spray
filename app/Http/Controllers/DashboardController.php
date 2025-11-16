<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Diskon;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $creator_id = Auth::id();

        // Eager load diskon dan relasi lainnya
        $my_products = Product::where('creator_id', $creator_id)
            ->with(['diskon', 'category'])
            ->get();

        // Hitung revenue dari order yang sudah dibayar
        $my_revenue = ProductOrder::where('creator_id', $creator_id)
            ->where('is_paid', 1)
            ->sum('total_price');

        // Count total order yang sukses
        $total_order_success = ProductOrder::where('creator_id', $creator_id)
            ->where('is_paid', 1)
            ->count();

        // Hitung total revenue yang mungkin didapat (sebelum diskon)
        $potential_revenue = $my_products->sum('price') * $total_order_success;

        // Hitung total diskon yang diberikan
        $total_discount_given = $potential_revenue - $my_revenue;

        // Hitung statistik produk dengan diskon
        $products_with_discount = $my_products->filter(function ($product) {
            return $product->diskon !== null;
        })->count();

        return view('admin.dashboard', [
            'my_products' => $my_products,
            'my_revenue' => $my_revenue,
            'total_order_success' => $total_order_success,
            'potential_revenue' => $potential_revenue,
            'total_discount_given' => $total_discount_given,
            'products_with_discount' => $products_with_discount,
        ]);
    }
}
