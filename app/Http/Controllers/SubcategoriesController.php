<?php

namespace App\Http\Controllers;

use App\Models\Subcategories;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Models\Category;

class SubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subcategories = Subcategories::all();
        $categories = Category::all();

        $query = Product::with('diskon');

        // Filter berdasarkan category (jika ada)
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan subcategory (jika ada)
        if ($request->has('subcategory') && $request->subcategory != '') {
            $query->where('subcategory_id', $request->subcategory);
        }

        // Ambil produk dengan pagination
        $products = $query->latest()->paginate(12);
       
        return view('front.lainnya', [
            'subcategories' => $subcategories,
            'categories' => $categories,
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategories $subcategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategories $subcategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategories $subcategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategories $subcategories)
    {
        //
    }
}
