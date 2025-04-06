<?php
namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::latest()->get();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create');
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

        Vendor::create($validated);

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor created successfully.');
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'nullable|email|max:255|unique:vendors',
            'phone'                => 'nullable|string|max:255',
            'address'              => 'nullable|string',
            'city'                 => 'nullable|string|max:255',
            'state'                => 'nullable|string|max:255',
            'zip'                  => 'nullable|string|max:255',
            'opening_balance'      => 'nullable|numeric',
            'opening_balance_type' => 'nullable|in:debit,credit',
        ]);

        $vendor = Vendor::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Vendor created successfully',
            'data'    => $vendor,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
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

        $vendor->update($validated);

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }
}
