<?php
namespace App\Http\Controllers;

use App\Imports\MedicineImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MedicineImportController extends Controller
{
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
