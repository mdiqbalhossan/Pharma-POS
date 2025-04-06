<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * Search medicines
     */
    public function searchMedicines(Request $request)
    {
        $search = $request->term;

        $medicines = Medicine::where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%")
                ->orWhere('generic_name', 'like', "%{$search}%");
        })->isActive()->take(15)->get();

        $results = [];
        foreach ($medicines as $medicine) {
            $results[] = [
                'label'    => $medicine->name,
                'value'    => $medicine->name,
                'medicine' => $medicine,
            ];
        }

        return response()->json($results);
    }
}
