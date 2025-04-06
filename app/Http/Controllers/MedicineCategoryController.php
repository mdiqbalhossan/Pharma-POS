<?php
namespace App\Http\Controllers;

use App\Models\MedicineCategory;
use Illuminate\Http\Request;

class MedicineCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicineCategories = MedicineCategory::latest()->get();
        return view('medicine_categories.index', compact('medicineCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:medicine_categories',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        MedicineCategory::create($request->all());
        return redirect()->route('medicine-categories.index')
            ->with('success', 'Medicine Category created successfully.');
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:medicine_categories',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->all();
        if (! isset($data['is_active'])) {
            $data['is_active'] = 0;
        }

        $category = MedicineCategory::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Medicine Category created successfully',
            'data'    => $category,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicineCategory $medicineCategory)
    {
        return view('medicine_categories.show', compact('medicineCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicineCategory $medicineCategory)
    {
        return view('medicine_categories.edit', compact('medicineCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicineCategory $medicineCategory)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:medicine_categories,name,' . $medicineCategory->id,
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $medicineCategory->update($request->all());
        return redirect()->route('medicine-categories.index')
            ->with('success', 'Medicine Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicineCategory $medicineCategory)
    {
        $medicineCategory->delete();
        return redirect()->route('medicine-categories.index')
            ->with('success', 'Medicine Category deleted successfully.');
    }
}
