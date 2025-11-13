<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('creator_id', Auth::id())
            ->get()
            ->keyBy('id');
        $diskon = Diskon::all();

        // Kirim data ke view
        return view('admin.diskon.index', [
            'products' => $products,
            "diskons" => $diskon
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
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:aktif,tidak aktif'],
        ]);
        DB::beginTransaction();
        try {

            Diskon::create($validated);
            DB::commit();

            return redirect()->route('admin.diskon.index')->with('success', 'Diskon created successfuly!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['product_id' => 'Produk ini telah memiliki diskon']);
            }

            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);

            throw $error;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Diskon $diskon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diskon $diskon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diskon $diskon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diskon $diskon)
    {
        try {
            $diskon->delete();
            return redirect()->route('admin.diskon.index')->with('success', 'Diskon telah dihapus!');
        } catch (\Exception $e) {
            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
        }
    }
}
