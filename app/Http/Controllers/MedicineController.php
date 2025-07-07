<?php
namespace App\Http\Controllers;

use App\Imports\MedicineImport;
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
use Maatwebsite\Excel\Facades\Excel;

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
            'sell_unit_multiple'    => 'boolean',
            'medicine_categories'   => 'nullable|array',
            'medicine_categories.*' => 'exists:medicine_categories,id',
        ]);

        // Validate medicine units if sell_unit_multiple is checked
        if ($request->has('sell_unit_multiple')) {
            $request->validate([
                'medicine_units.unit_id'             => 'required|array',
                'medicine_units.unit_id.*'           => 'required|exists:units,id',
                'medicine_units.conversion_factor'   => 'required|array',
                'medicine_units.conversion_factor.*' => 'required|numeric|min:0.01',
                'medicine_units.sale_price'          => 'required|array',
                'medicine_units.sale_price.*'        => 'required|numeric|min:0',
                'medicine_units.purchase_price'      => 'required|array',
                'medicine_units.purchase_price.*'    => 'required|numeric|min:0',
            ]);
        }

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
        $validated['sell_unit_multiple']  = $request->has('sell_unit_multiple');

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

            // Store medicine units if sell_unit_multiple is checked
            if ($request->has('sell_unit_multiple') && isset($request->medicine_units)) {
                $unitCount = count($request->medicine_units['unit_id']);

                for ($i = 0; $i < $unitCount; $i++) {
                    $medicine->medicine_units()->create([
                        'unit_id'           => $request->medicine_units['unit_id'][$i],
                        'conversion_factor' => $request->medicine_units['conversion_factor'][$i],
                        'sale_price'        => $request->medicine_units['sale_price'][$i],
                        'purchase_price'    => $request->medicine_units['purchase_price'][$i],
                        'is_default'        => isset($request->medicine_units['is_default'][$i]) ? 1 : 0,
                    ]);
                }
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
            'sell_unit_multiple'    => 'boolean',
            'medicine_categories'   => 'nullable|array',
            'medicine_categories.*' => 'exists:medicine_categories,id',
        ]);

        // Validate medicine units if sell_unit_multiple is checked
        if ($request->has('sell_unit_multiple')) {
            $request->validate([
                'medicine_units.unit_id'             => 'required|array',
                'medicine_units.unit_id.*'           => 'required|exists:units,id',
                'medicine_units.conversion_factor'   => 'required|array',
                'medicine_units.conversion_factor.*' => 'required|numeric|min:0.01',
                'medicine_units.sale_price'          => 'required|array',
                'medicine_units.sale_price.*'        => 'required|numeric|min:0',
                'medicine_units.purchase_price'      => 'required|array',
                'medicine_units.purchase_price.*'    => 'required|numeric|min:0',
            ]);
        }

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
        $validated['sell_unit_multiple']  = $request->has('sell_unit_multiple');

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

            // Update medicine units
            if ($request->has('sell_unit_multiple') && isset($request->medicine_units)) {
                // Delete existing units
                $medicine->medicine_units()->delete();

                // Add new units
                $unitCount = count($request->medicine_units['unit_id']);

                for ($i = 0; $i < $unitCount; $i++) {
                    $medicine->medicine_units()->create([
                        'unit_id'           => $request->medicine_units['unit_id'][$i],
                        'conversion_factor' => $request->medicine_units['conversion_factor'][$i],
                        'sale_price'        => $request->medicine_units['sale_price'][$i],
                        'purchase_price'    => $request->medicine_units['purchase_price'][$i],
                        'is_default'        => isset($request->medicine_units['is_default'][$i]) ? 1 : 0,
                    ]);
                }
            } else {
                // If sell_unit_multiple is unchecked, delete all units
                $medicine->medicine_units()->delete();
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
        $medicine->medicine_units()->delete();
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }

    /**
     * Show the import form for importing medicines.
     */
    public function importForm()
    {
        return view('medicine.modal.import');
    }

    /**
     * Process the import of medicines from a CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new MedicineImport, $request->file('file'));
            return redirect()->route('medicines.index')
                ->with('success', 'Medicines imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('medicines.index')
                ->with('error', 'Failed to import medicines: ' . $e->getMessage());
        }
    }

    /**
     * Download a sample CSV file for medicine import.
     */
    public function downloadSample()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="medicine_import_sample.csv"',
        ];

        $columns = [
            'name', 'generic_name', 'medicine_type', 'medicine_leaf', 'unit', 'supplier', 'vendor',
            'sale_price', 'purchase_price', 'vat_percentage', 'discount_percentage', 'igta',
            'shelf', 'hns_code', 'dosage', 'barcode', 'batch_number', 'manufacturing_date',
            'expiration_date', 'serial_number', 'lot_number', 'quantity', 'reorder_level',
            'alert_quantity', 'storage_condition', 'prescription_required', 'side_effects',
            'contraindications', 'loyalty_point', 'description', 'is_active', 'medicine_categories',
        ];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Add sample data
            fputcsv($file, [
                'Paracetamol', 'Acetaminophen', 'Tablet', 'Strip', 'Box', 'ABC Supplier', 'XYZ Vendor',
                '10.00', '8.00', '5', '0', '', 'A-1', '', '500 mg', '123456789', 'BN123',
                date('Y-m-d'), date('Y-m-d', strtotime('+2 years')), '', 'LN123', '100', '20',
                '10', 'Store in a cool, dry place', 'no', 'Nausea, vomiting', 'Liver disease',
                '1', 'Pain reliever and fever reducer', 'yes', 'Pain Reliever,Fever Reducer',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
