<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Vendor;
use Illuminate\Http\Request;

class BarcodeGenerateController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('medicine.print_barcode', compact('vendors'));
    }

    /**
     * Search medicine for autocomplete
     */
    public function searchMedicine(Request $request)
    {
        $term = $request->get('term');

        $medicines = Medicine::where('name', 'LIKE', '%' . $term . '%')
            ->orWhere('generic_name', 'LIKE', '%' . $term . '%')
            ->orWhere('barcode', 'LIKE', '%' . $term . '%')
            ->select('id', 'name', 'generic_name', 'barcode', 'sale_price', 'image')
            ->limit(10)
            ->get();

        $result = [];
        foreach ($medicines as $medicine) {
            $result[] = [
                'id'           => $medicine->id,
                'value'        => $medicine->name,
                'name'         => $medicine->name,
                'generic_name' => $medicine->generic_name,
                'barcode'      => $medicine->barcode,
                'price'        => $medicine->sale_price,
                'image'        => $medicine->image,
            ];
        }

        return response()->json($result);
    }

    /**
     * Generate barcode preview
     */
    public function generateBarcode(Request $request)
    {
        $products        = $request->products;
        $paperSize       = $request->paper_size;
        $showVendorName  = $request->show_vendor_name;
        $showProductName = $request->show_product_name;
        $showPrice       = $request->show_price;
        $vendor          = $request->vendor_id ? Vendor::find($request->vendor_id) : null;

        return view('medicine.barcode_preview', compact(
            'products',
            'paperSize',
            'showVendorName',
            'showProductName',
            'showPrice',
            'vendor'
        ));
    }
}
