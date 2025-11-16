<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Diskon;
use App\Models\Product;
use App\Models\Subcategories;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(Request $request)
    {
        $categories = Category::all();
        $subcategories = Subcategories::all();
        
        // Query builder untuk products dengan relasi diskon
        $query = Product::with('diskon');
        
        // Filter berdasarkan category (jika ada)
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
            
            // Filter subcategories berdasarkan category yang dipilih
            $subcategories = Subcategories::where('category_id', $request->category)->get();
        }
        
        // Filter berdasarkan subcategory (jika ada)
        if ($request->has('subcategory') && $request->subcategory != '') {
            $query->where('sub_category_id', $request->subcategory);
        }
       
        // Ambil produk dengan pagination
        $products = $query->latest()->get();
        
        return view('front.index', [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

      // Method untuk mendapatkan subcategories berdasarkan category (AJAX)
    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategories::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }

    public function details(Product $product)
    {
        // Eager load diskon untuk menghindari error "Trying to get property of non-object"
        $other_products = Product::with(['diskon', 'category', 'creator'])
            ->where('id', '!=', $product->id)
            ->get();

        $creator_id = $product->creator_id;

        $creator_products = Product::with(['diskon', 'creator'])
            ->where('creator_id', $creator_id)
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
