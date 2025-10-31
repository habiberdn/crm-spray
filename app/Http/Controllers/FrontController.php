<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Diskon;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index()
    {
        $products = Product::with('diskon')->get();
        $categories = Category::all();

        return view('front.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

   public function details(Product $product)
{
    // Eager load diskon untuk menghindari error "Trying to get property of non-object"
    $other_products = Product::with(['diskon', 'category', 'creator'])
                            ->where('id', '!=', $product->id)
                            ->get();
    
    $creator_id = $product->creator_id;
    
    $creator_products = Product::with(['diskon', 'category', 'creator'])
                              ->where('creator_id', $creator_id)
                              ->where('id', '!=', $product->id) // Exclude current product
                              ->get();

    return view('front.details', [
        'product' => $product->load(['diskon', 'category', 'creator']), // Load relasi untuk product saat ini
        'other_products' => $other_products,
        'creator_products' => $creator_products,
    ]);
}
    public function category(Category $category)
    {
        $product_categories = Product::where('category_id', $category->id)->get();
        $diskon = Diskon::all();
        return view('front.category', [
            'category' => $category,
            'product_categories' => $product_categories,
            'diskon' => $diskon
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::query()

            ->where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('category', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })->get();

        return view('front.search', [
            'products' => $products
        ]);
    }
}
