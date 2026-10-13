<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $discounts = Discount::latest()->get();
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create() {
        return view('admin.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:discounts,code',
            'percentage' => 'required|integer|min:1|max:100',
            'expires_at' => 'required|date',
        ]);
        Discount::create($request->all());
        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            // Validasi 'unique' harus mengecualikan ID diskon ini sendiri
            'code' => 'required|string|uppercase|unique:discounts,code,' . $discount->id,
            'percentage' => 'required|integer|min:1|max:100',
            'description' => 'required|string|max:255',
            'min_purchase' => 'required|integer|min:0',
            'expires_at' => 'required|date',
            'is_active' => 'required|boolean',
        ]);

        $discount->update($request->all());

        return redirect()->route('admin.discounts.index')
                         ->with('success', 'Voucher berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount) {
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'Diskon dihapus');
    }
}
