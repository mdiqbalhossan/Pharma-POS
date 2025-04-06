<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\SaleReturn;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saleReturns = SaleReturn::with(['sale', 'medicine'])->latest()->get();
        return view('sales_return.index', compact('saleReturns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('sales.index');
    }

    /**
     * Create return from sale.
     */
    public function createFromSale(Sales $sale)
    {
        $sale->load('medicines', 'customer');

        return view('sales_return.create', compact('sale'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sale_id'        => 'required|exists:sales,id',
            'medicine_id'    => 'required|exists:medicines,id',
            'quantity'       => 'required|integer|min:1',
            'unit_price'     => 'required|numeric|min:0',
            'total_price'    => 'required|numeric|min:0',
            'discount'       => 'required|numeric|min:0',
            'tax'            => 'required|numeric|min:0',
            'grand_total'    => 'required|numeric|min:0',
            'paid_amount'    => 'required|numeric|min:0',
            'due_amount'     => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'note'           => 'nullable|string',
            'confirmation'   => 'required|accepted',
        ]);

        $sale     = Sales::findOrFail($request->sale_id);
        $medicine = Medicine::findOrFail($request->medicine_id);

        // Get sold quantity
        $soldQuantity = DB::table('medicine_sale')
            ->where('sales_id', $sale->id)
            ->where('medicine_id', $medicine->id)
            ->value('quantity');

        // Validate return quantity
        if ($request->quantity > $soldQuantity) {
            return redirect()->back()->with('error', 'Return quantity cannot be greater than sold quantity.');
        }

        DB::beginTransaction();

        try {
            // Create sale return
            $saleReturn = SaleReturn::create([
                'sale_id'        => $request->sale_id,
                'medicine_id'    => $request->medicine_id,
                'quantity'       => $request->quantity,
                'unit_price'     => $request->unit_price,
                'total_price'    => $request->total_price,
                'discount'       => $request->discount,
                'tax'            => $request->tax,
                'grand_total'    => $request->grand_total,
                'paid_amount'    => $request->paid_amount,
                'due_amount'     => $request->due_amount,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
            ]);

            // Update stock (increase medicine quantity on return)
            if ($medicine) {
                $medicine->quantity = ($medicine->quantity ?? 0) + $request->quantity;
                $medicine->save();
            }

            DB::commit();

            return redirect()->route('sale-returns.index')->with('success', 'Sale return created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleReturn $saleReturn)
    {
        $saleReturn->load('sale', 'medicine');
        return view('sales_return.show', compact('saleReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleReturn $saleReturn)
    {
        return redirect()->route('sale-returns.index')->with('error', 'Sale returns cannot be edited.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleReturn $saleReturn)
    {
        return redirect()->route('sale-returns.index')->with('error', 'Sale returns cannot be updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleReturn $saleReturn)
    {
        return redirect()->route('sale-returns.index')->with('error', 'Sale returns cannot be deleted.');
    }
}
