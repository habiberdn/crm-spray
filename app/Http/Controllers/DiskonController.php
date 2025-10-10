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
                          ->keyBy('id'); // <<< Kunci penting!

        // Kirim data ke view
        return view('admin.diskon.index', [
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
        var_dump("Masukk");
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:255'],
            'value' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'start_date' => ['required', 'string', 'max:65535'],
            'end__datetime' => ['required', 'string', 'max:65535'],
            'status' => ['required', 'string', 'max:65535'],
        ]);
        DB::beginTransaction();
        die();
        try{
           
            Diskon::create($validated);
            DB::commit();

            return redirect()->route('admin.diskon')->with('success', 'Diskon created successfuly!');
        }
        catch(\Exception $e){
            DB::rollBack();

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
        //
    }
}
