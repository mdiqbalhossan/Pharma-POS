<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\Sales;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $medicineCategories = MedicineCategory::with('medicines')->get();
        $medicines          = Medicine::latest()->get()->take(20);
        $customers          = Customer::latest()->get();
        $saleNumber         = Sales::generateSaleNumber();
        $holdOrders         = Sales::where('status', 'pending')->latest()->get();
        $unpaidOrders       = Sales::where('status', 'success')->where('payment_status', 'unpaid')->latest()->get();
        $paidOrders         = Sales::where('status', 'success')->where('payment_status', 'paid')->latest()->get();
        $cancelledOrders    = Sales::where('status', 'cancelled')->latest()->get();
        return view('pos.index', compact('medicineCategories', 'medicines', 'customers', 'saleNumber', 'holdOrders', 'unpaidOrders', 'paidOrders', 'cancelledOrders'));
    }

    public function search(Request $request)
    {
        $medicines = Medicine::with(['medicine_type', 'medicine_leaf', 'unit', 'supplier', 'vendor', 'medicine_categories'])->search($request->search)->get();
        return response()->json($medicines);
    }

    public function storeCustomer(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'required|string|max:20',
            'country' => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'success'  => true,
            'message'  => 'Customer added successfully',
            'customer' => $customer,
        ]);
    }

    public function getMedicine($id)
    {
        $medicine = Medicine::find($id);
        return response()->json($medicine);
    }

    /**
     * Get alternate medicines based on generic name
     */
    public function getAlternateMedicines($id)
    {
        $medicine = Medicine::find($id);

        if (! $medicine) {
            return response()->json([
                'success' => false,
                'message' => 'Medicine not found',
            ]);
        }

        // Get medicines with the same generic name but different ID
        $alternateMedicines = Medicine::with(['medicine_type', 'medicine_leaf', 'unit', 'supplier', 'vendor'])
            ->where('generic_name', $medicine->generic_name)
            ->where('id', '!=', $medicine->id)
            ->where('quantity', '>', 0) // Only show medicines that are in stock
            ->get();

        return response()->json([
            'success'    => true,
            'medicine'   => $medicine,
            'alternates' => $alternateMedicines,
        ]);
    }

    /**
     * Search orders by keyword and status
     */
    public function searchOrders(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = Sales::with(['user', 'customer'])
            ->where(function ($q) use ($search) {
                // Search in sale_no
                $q->where('sale_no', 'like', "%{$search}%")
                // Or search in customer name
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                // Or search in user/cashier name
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });

        // Filter by status
        switch ($status) {
            case 'onhold':
                $query->where('status', 'pending');
                break;
            case 'unpaid':
                $query->where('status', 'success')->where('payment_status', 'unpaid');
                break;
            case 'paid':
                $query->where('status', 'success')->where('payment_status', 'paid');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
        }

        $orders = $query->latest()->get();

        return response()->json([
            'success' => true,
            'orders'  => $orders,
        ]);
    }

    /**
     * Get orders by status
     */
    public function getOrders(Request $request)
    {
        $status = $request->status;
        $query  = Sales::with(['user', 'customer']);

        // Filter by status
        switch ($status) {
            case 'onhold':
                $query->where('status', 'pending');
                break;
            case 'unpaid':
                $query->where('status', 'success')->where('payment_status', 'unpaid');
                break;
            case 'paid':
                $query->where('status', 'success')->where('payment_status', 'paid');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
        }

        $orders = $query->latest()->get();

        return response()->json([
            'success' => true,
            'orders'  => $orders,
        ]);
    }
}
