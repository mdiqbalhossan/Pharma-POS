<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'nullable|email|max:255',
            'phone'                => 'required|string|max:20',
            'address'              => 'nullable|string|max:255',
            'city'                 => 'nullable|string|max:100',
            'state'                => 'nullable|string|max:100',
            'zip'                  => 'nullable|string|max:20',
            'opening_balance'      => 'nullable|numeric',
            'opening_balance_type' => 'nullable|in:debit,credit',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'nullable|email|max:255|unique:suppliers',
            'phone'                => 'nullable|string|max:255',
            'address'              => 'nullable|string',
            'city'                 => 'nullable|string|max:255',
            'state'                => 'nullable|string|max:255',
            'zip'                  => 'nullable|string|max:255',
            'opening_balance'      => 'nullable|numeric',
            'opening_balance_type' => 'nullable|in:debit,credit',
        ]);

        $supplier = Supplier::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Supplier created successfully',
            'data'    => $supplier,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'nullable|email|max:255',
            'phone'                => 'required|string|max:20',
            'address'              => 'nullable|string|max:255',
            'city'                 => 'nullable|string|max:100',
            'state'                => 'nullable|string|max:100',
            'zip'                  => 'nullable|string|max:20',
            'opening_balance'      => 'nullable|numeric',
            'opening_balance_type' => 'nullable|in:debit,credit',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
