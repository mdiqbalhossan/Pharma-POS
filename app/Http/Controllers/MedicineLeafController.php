<?php
namespace App\Http\Controllers;

use App\Models\MedicineLeaf;
use Illuminate\Http\Request;

class MedicineLeafController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicineLeafs = MedicineLeaf::latest()->get();
        return view('medicine_leafs.index', compact('medicineLeafs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine_leafs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'    => 'required|string|max:255|unique:medicine_leafs',
            'qty_box' => 'required|numeric',
        ]);

        MedicineLeaf::create($request->all());
        return redirect()->route('medicine-leafs.index')
            ->with('success', 'Medicine leaf created successfully.');
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'type'    => 'required|string|max:255|unique:medicine_leafs',
            'qty_box' => 'required|numeric',
        ]);

        $leaf = MedicineLeaf::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Medicine Leaf created successfully',
            'data'    => $leaf,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicineLeaf $medicineLeaf)
    {
        return view('medicine_leafs.show', compact('medicineLeaf'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicineLeaf $medicineLeaf)
    {
        return view('medicine_leafs.edit', compact('medicineLeaf'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicineLeaf $medicineLeaf)
    {
        $request->validate([
            'type'    => 'required|string|max:255|unique:medicine_leafs,type,' . $medicineLeaf->id,
            'qty_box' => 'required|numeric',
        ]);

        $medicineLeaf->update($request->all());
        return redirect()->route('medicine-leafs.index')
            ->with('success', 'Medicine leaf updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicineLeaf $medicineLeaf)
    {
        $medicineLeaf->delete();
        return redirect()->route('medicine-leafs.index')
            ->with('success', 'Medicine leaf deleted successfully.');
    }
}
