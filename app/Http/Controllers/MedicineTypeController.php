<?php
namespace App\Http\Controllers;

use App\Models\MedicineType;
use Illuminate\Http\Request;

class MedicineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicineTypes = MedicineType::latest()->get();
        return view('medicine_types.index', compact('medicineTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:medicine_types',
            'description' => 'nullable|string',
        ]);

        MedicineType::create($request->all());
        return redirect()->route('medicine-types.index')
            ->with('success', 'Medicine type created successfully.');
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:medicine_types',
            'description' => 'nullable|string',
        ]);

        $type = MedicineType::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Medicine Type created successfully',
            'data'    => $type,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicineType $medicineType)
    {
        return view('medicine_types.show', compact('medicineType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicineType $medicineType)
    {
        return view('medicine_types.edit', compact('medicineType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicineType $medicineType)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:medicine_types,name,' . $medicineType->id,
            'description' => 'nullable|string',
        ]);

        $medicineType->update($request->all());
        return redirect()->route('medicine-types.index')
            ->with('success', 'Medicine type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicineType $medicineType)
    {
        $medicineType->delete();
        return redirect()->route('medicine-types.index')
            ->with('success', 'Medicine type deleted successfully.');
    }
}
