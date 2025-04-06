<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::stockIn()->isActive();

        // Apply filters
        $query = $this->applyFilters($request, $query);

        $medicines           = $query->get();
        $medicine_categories = MedicineCategory::all();
        $vendors             = Vendor::all();

        return view('stock.manage_stock', compact('medicines', 'medicine_categories', 'vendors'));
    }

    public function lowStock(Request $request)
    {
        $query = Medicine::lowStock()->isActive();

        // Apply filters
        $query = $this->applyFilters($request, $query);

        $medicines           = $query->get();
        $medicine_categories = MedicineCategory::all();
        $vendors             = Vendor::all();

        return view('stock.low_stock', compact('medicines', 'medicine_categories', 'vendors'));
    }

    public function outOfStock(Request $request)
    {
        $query = Medicine::outOfStock()->isActive();

        // Apply filters
        $query = $this->applyFilters($request, $query);

        $medicines           = $query->get();
        $medicine_categories = MedicineCategory::all();
        $vendors             = Vendor::all();

        return view('stock.out_of_stock', compact('medicines', 'medicine_categories', 'vendors'));
    }

    public function upcomingExpired(Request $request)
    {
        $query = Medicine::upcomingExpired()->isActive();

        // Apply filters
        $query = $this->applyFilters($request, $query);

        $medicines           = $query->get();
        $medicine_categories = MedicineCategory::all();
        $vendors             = Vendor::all();

        return view('stock.upcoming_expired', compact('medicines', 'medicine_categories', 'vendors'));
    }

    public function alreadyExpired(Request $request)
    {
        $query = Medicine::alreadyExpired()->isActive();

        // Apply filters
        $query = $this->applyFilters($request, $query);

        $medicines           = $query->get();
        $medicine_categories = MedicineCategory::all();
        $vendors             = Vendor::all();

        return view('stock.already_expired', compact('medicines', 'medicine_categories', 'vendors'));
    }

    /**
     * Apply filters to the query
     */
    private function applyFilters(Request $request, $query)
    {
        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('medicine_category_id', $request->category_id);
        }

        // Filter by vendor
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        // Sort by price
        if ($request->filled('sort_by')) {
            if ($request->sort_by === 'lowest') {
                $query->orderBy('sale_price', 'asc');
            } elseif ($request->sort_by === 'highest') {
                $query->orderBy('sale_price', 'desc');
            }
        }

        return $query;
    }
}
