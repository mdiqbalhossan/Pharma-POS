<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineLeaf;
use App\Models\MedicineType;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::with(['medicine_type', 'medicine_leaf', 'unit', 'supplier', 'vendor'])->latest()->get();
        return view('medicine.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicineTypes      = MedicineType::all();
        $medicineLeafs      = MedicineLeaf::all();
        $units              = Unit::all();
        $suppliers          = Supplier::all();
        $vendors            = Vendor::all();
        $medicineCategories = MedicineCategory::all();

        return view('medicine.create', compact(
            'medicineTypes',
            'medicineLeafs',
            'units',
            'suppliers',
            'vendors',
            'medicineCategories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'generic_name'          => 'nullable|string|max:255',
            'medicine_type_id'      => 'required|exists:medicine_types,id',
            'medicine_leaf_id'      => 'required|exists:medicine_leafs,id',
            'unit_id'               => 'required|exists:units,id',
            'supplier_id'           => 'nullable|exists:suppliers,id',
            'vendor_id'             => 'nullable|exists:vendors,id',
            'sale_price'            => 'required|numeric|min:0',
            'purchase_price'        => 'required|numeric|min:0',
            'vat_percentage'        => 'nullable|numeric|min:0|max:100',
            'discount_percentage'   => 'nullable|numeric|min:0|max:100',
            'igta'                  => 'nullable|string|max:255',
            'shelf'                 => 'nullable|string|max:255',
            'hns_code'              => 'nullable|string|max:255',
            'dosage'                => 'nullable|string|max:255',
            'barcode'               => 'nullable|string|max:255|unique:medicines,barcode',
            'batch_number'          => 'nullable|string|max:255',
            'manufacturing_date'    => 'nullable|date',
            'expiration_date'       => 'nullable|date|after:manufacturing_date',
            'serial_number'         => 'nullable|string|max:255',
            'lot_number'            => 'nullable|string|max:255',
            'reorder_level'         => 'nullable|integer|min:0',
            'alert_quantity'        => 'nullable|integer|min:0',
            'storage_condition'     => 'nullable|string|max:255',
            'prescription_required' => 'boolean',
            'side_effects'          => 'nullable|string',
            'contraindications'     => 'nullable|string',
            'loyalty_point'         => 'nullable|integer|min:0',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'           => 'nullable|string',
            'is_active'             => 'boolean',
            'medicine_categories'   => 'nullable|array',
            'medicine_categories.*' => 'exists:medicine_categories,id',
        ]);

        // Format dates for MySQL
        if (! empty($validated['manufacturing_date'])) {
            $validated['manufacturing_date'] = date('Y-m-d', strtotime($validated['manufacturing_date']));
        }

        if (! empty($validated['expiration_date'])) {
            $validated['expiration_date'] = date('Y-m-d', strtotime($validated['expiration_date']));
        }
        $validated['loyalty_point']       = $request->filled('loyalty_point') ? $request->input('loyalty_point') : 0;
        $validated['vat_percentage']      = $request->filled('vat_percentage') ? $request->input('vat_percentage') : null;
        $validated['discount_percentage'] = $request->filled('discount_percentage') ? $request->input('discount_percentage') : null;
        $validated['reorder_level']       = $request->filled('reorder_level') ? $request->input('reorder_level') : null;
        $validated['alert_quantity']      = $request->filled('alert_quantity') ? $request->input('alert_quantity') : null;
        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = uploadImage($request, 'image', 'uploads/medicines');
        }
        DB::beginTransaction();
        try {
            // Create medicine
            $medicine = Medicine::create($validated);
            // Sync medicine categories
            if (isset($validated['medicine_categories'])) {
                $medicine->medicine_categories()->sync($validated['medicine_categories']);
            }

            DB::commit();
            return redirect()->route('medicines.index')
                ->with('success', 'Medicine created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            log_message('error', $e->getMessage());
            return redirect()->route('medicines.index')
                ->with('error', 'Failed to create medicine.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        $medicine->load(['medicine_type', 'medicine_leaf', 'unit', 'supplier', 'vendor', 'medicine_categories']);
        return view('medicine.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        $medicineTypes      = MedicineType::all();
        $medicineLeafs      = MedicineLeaf::all();
        $units              = Unit::all();
        $suppliers          = Supplier::all();
        $vendors            = Vendor::all();
        $medicineCategories = MedicineCategory::all();

        $medicine->load('medicine_categories');

        return view('medicine.edit', compact(
            'medicine',
            'medicineTypes',
            'medicineLeafs',
            'units',
            'suppliers',
            'vendors',
            'medicineCategories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'generic_name'          => 'nullable|string|max:255',
            'medicine_type_id'      => 'required|exists:medicine_types,id',
            'medicine_leaf_id'      => 'required|exists:medicine_leafs,id',
            'unit_id'               => 'required|exists:units,id',
            'supplier_id'           => 'nullable|exists:suppliers,id',
            'vendor_id'             => 'nullable|exists:vendors,id',
            'sale_price'            => 'required|numeric|min:0',
            'purchase_price'        => 'required|numeric|min:0',
            'vat_percentage'        => 'nullable|numeric|min:0|max:100',
            'discount_percentage'   => 'nullable|numeric|min:0|max:100',
            'igta'                  => 'nullable|string|max:255',
            'shelf'                 => 'nullable|string|max:255',
            'hns_code'              => 'nullable|string|max:255',
            'dosage'                => 'nullable|string|max:255',
            'barcode'               => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('medicines')->ignore($medicine->id),
            ],
            'batch_number'          => 'nullable|string|max:255',
            'manufacturing_date'    => 'nullable|date',
            'expiration_date'       => 'nullable|date|after:manufacturing_date',
            'serial_number'         => 'nullable|string|max:255',
            'lot_number'            => 'nullable|string|max:255',
            'reorder_level'         => 'nullable|integer|min:0',
            'alert_quantity'        => 'nullable|integer|min:0',
            'storage_condition'     => 'nullable|string|max:255',
            'prescription_required' => 'boolean',
            'side_effects'          => 'nullable|string',
            'contraindications'     => 'nullable|string',
            'loyalty_point'         => 'required|integer|min:0',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'           => 'nullable|string',
            'is_active'             => 'boolean',
            'medicine_categories'   => 'nullable|array',
            'medicine_categories.*' => 'exists:medicine_categories,id',
        ]);

        // Format dates for MySQL
        if (! empty($validated['manufacturing_date'])) {
            $validated['manufacturing_date'] = date('Y-m-d', strtotime($validated['manufacturing_date']));
        }

        if (! empty($validated['expiration_date'])) {
            $validated['expiration_date'] = date('Y-m-d', strtotime($validated['expiration_date']));
        }

        $validated['loyalty_point']       = $request->filled('loyalty_point') ? $request->input('loyalty_point') : 0;
        $validated['vat_percentage']      = $request->filled('vat_percentage') ? $request->input('vat_percentage') : null;
        $validated['discount_percentage'] = $request->filled('discount_percentage') ? $request->input('discount_percentage') : null;
        $validated['reorder_level']       = $request->filled('reorder_level') ? $request->input('reorder_level') : null;
        $validated['alert_quantity']      = $request->filled('alert_quantity') ? $request->input('alert_quantity') : null;

        // Update slug
        $validated['slug'] = Str::slug($validated['name']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($medicine->image) {
                Storage::delete('public/' . $medicine->image);
            }

            $validated['image'] = uploadImage($request, 'image', 'uploads/medicines');
        }
        DB::beginTransaction();
        try {
            // Update medicine
            $medicine->update($validated);

            // Sync medicine categories
            if (isset($validated['medicine_categories'])) {
                $medicine->medicine_categories()->sync($validated['medicine_categories']);
            } else {
                $medicine->medicine_categories()->detach();
            }

            DB::commit();
            return redirect()->route('medicines.index')
                ->with('success', 'Medicine updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            log_message('error', $e->getMessage());
            return redirect()->route('medicines.index')
                ->with('error', 'Failed to update medicine.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        // Delete image if exists
        if ($medicine->image) {
            Storage::delete('public/' . $medicine->image);
        }

        // Delete medicine
        $medicine->medicine_categories()->detach();
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }
}
