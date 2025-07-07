<?php
namespace App\Imports;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineLeaf;
use App\Models\MedicineType;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicineImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['name'])) {
                continue; // Skip if name is empty
            }

            DB::beginTransaction();
            try {
                // Process medicine type
                $medicineTypeId = null;
                if (! empty($row['medicine_type'])) {
                    $medicineType = MedicineType::firstOrCreate(
                        ['name' => $row['medicine_type']],
                        ['slug' => Str::slug($row['medicine_type'])]
                    );
                    $medicineTypeId = $medicineType->id;
                }

                // Process medicine leaf
                $medicineLeafId = null;
                if (! empty($row['medicine_leaf'])) {
                    $medicineLeaf = MedicineLeaf::firstOrCreate(
                        ['name' => $row['medicine_leaf']],
                        ['slug' => Str::slug($row['medicine_leaf'])]
                    );
                    $medicineLeafId = $medicineLeaf->id;
                }

                // Process unit
                $unitId = null;
                if (! empty($row['unit'])) {
                    $unit = Unit::firstOrCreate(
                        ['name' => $row['unit']],
                        ['slug' => Str::slug($row['unit'])]
                    );
                    $unitId = $unit->id;
                }

                // Process supplier
                $supplierId = null;
                if (! empty($row['supplier'])) {
                    $supplier = Supplier::firstOrCreate(
                        ['name' => $row['supplier']],
                        ['email' => strtolower(str_replace(' ', '', $row['supplier'])) . '@supplier.com', 'phone' => '0000000000']
                    );
                    $supplierId = $supplier->id;
                }

                // Process vendor
                $vendorId = null;
                if (! empty($row['vendor'])) {
                    $vendor = Vendor::firstOrCreate(
                        ['name' => $row['vendor']],
                        ['email' => strtolower(str_replace(' ', '', $row['vendor'])) . '@vendor.com', 'phone' => '0000000000']
                    );
                    $vendorId = $vendor->id;
                }

                // Create medicine
                $medicine = Medicine::create([
                    'name'                  => $row['name'],
                    'generic_name'          => $row['generic_name'] ?? null,
                    'medicine_type_id'      => $medicineTypeId,
                    'medicine_leaf_id'      => $medicineLeafId,
                    'unit_id'               => $unitId,
                    'supplier_id'           => $supplierId,
                    'vendor_id'             => $vendorId,
                    'sale_price'            => $row['sale_price'] ?? 0,
                    'purchase_price'        => $row['purchase_price'] ?? 0,
                    'vat_percentage'        => $row['vat_percentage'] ?? null,
                    'discount_percentage'   => $row['discount_percentage'] ?? null,
                    'igta'                  => $row['igta'] ?? null,
                    'shelf'                 => $row['shelf'] ?? null,
                    'hns_code'              => $row['hns_code'] ?? null,
                    'dosage'                => $row['dosage'] ?? null,
                    'barcode'               => $row['barcode'] ?? null,
                    'batch_number'          => $row['batch_number'] ?? null,
                    'manufacturing_date'    => ! empty($row['manufacturing_date']) ? date('Y-m-d', strtotime($row['manufacturing_date'])) : null,
                    'expiration_date'       => ! empty($row['expiration_date']) ? date('Y-m-d', strtotime($row['expiration_date'])) : null,
                    'serial_number'         => $row['serial_number'] ?? null,
                    'lot_number'            => $row['lot_number'] ?? null,
                    'quantity'              => $row['quantity'] ?? 0,
                    'reorder_level'         => $row['reorder_level'] ?? null,
                    'alert_quantity'        => $row['alert_quantity'] ?? null,
                    'storage_condition'     => $row['storage_condition'] ?? null,
                    'prescription_required' => isset($row['prescription_required']) ? ($row['prescription_required'] == 'yes' || $row['prescription_required'] == '1' ? true : false) : false,
                    'side_effects'          => $row['side_effects'] ?? null,
                    'contraindications'     => $row['contraindications'] ?? null,
                    'loyalty_point'         => $row['loyalty_point'] ?? 0,
                    'description'           => $row['description'] ?? null,
                    'is_active'             => isset($row['is_active']) ? ($row['is_active'] == 'yes' || $row['is_active'] == '1' ? true : false) : true,
                ]);

                // Process medicine categories
                if (! empty($row['medicine_categories'])) {
                    $categories  = explode(',', $row['medicine_categories']);
                    $categoryIds = [];

                    foreach ($categories as $categoryName) {
                        $categoryName = trim($categoryName);
                        if (! empty($categoryName)) {
                            $category = MedicineCategory::firstOrCreate(
                                ['name' => $categoryName],
                                ['slug' => Str::slug($categoryName)]
                            );
                            $categoryIds[] = $category->id;
                        }
                    }

                    if (! empty($categoryIds)) {
                        $medicine->medicine_categories()->sync($categoryIds);
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
