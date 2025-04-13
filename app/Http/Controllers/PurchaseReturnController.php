<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use App\Trait\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    use Transaction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseReturns = PurchaseReturn::with(['purchase', 'medicine'])->latest()->get();
        $suppliers       = Supplier::all();
        return view('purchase_return.index', compact('purchaseReturns', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('purchases.index');
    }

    /**
     * Create return from purchase.
     */
    public function createFromPurchase(Purchase $purchase)
    {
        $purchase->load('medicines', 'supplier');
        $accounts = Account::all();
        return view('purchase_return.create', compact('purchase', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchase_id'    => 'required|exists:purchases,id',
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
            'account_id'     => 'required|exists:accounts,id',
        ]);

        $purchase = Purchase::findOrFail($request->purchase_id);
        $medicine = Medicine::findOrFail($request->medicine_id);

        // Get purchased quantity and current stock
        $purchasedQuantity = DB::table('medicine_purchase')
            ->where('purchase_id', $purchase->id)
            ->where('medicine_id', $medicine->id)
            ->value('quantity');

        $currentStock = $medicine->quantity ?? 0;

        // Validate return quantity
        if ($request->quantity > $purchasedQuantity) {
            return redirect()->back()->with('error', 'Return quantity cannot be greater than purchased quantity.');
        }

        if ($request->quantity > $currentStock) {
            return redirect()->back()->with('error', 'Return quantity cannot be greater than current stock.');
        }

        DB::beginTransaction();

        try {
            // Create purchase return
            $purchaseReturn = PurchaseReturn::create([
                'purchase_id'    => $request->purchase_id,
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
                'account_id'     => $request->account_id,
            ]);

            // Update stock
            if ($medicine->quantity) {
                $medicine->quantity -= $request->quantity;
                $medicine->save();
            }

            $this->saveTransaction([
                'account_id'       => $request->account_id,
                'type'             => 'purchase_return',
                'amount'           => $request->grand_total,
                'transaction_date' => $request->date,
                'description'      => $request->note,
            ]);

            DB::commit();

            return redirect()->route('purchase-returns.index')->with('success', 'Purchase return created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->load('purchase', 'medicine');
        return view('purchase_return.show', compact('purchaseReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseReturn $purchaseReturn)
    {
        return redirect()->route('purchase-returns.index')->with('error', 'Purchase returns cannot be edited.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        return redirect()->route('purchase-returns.index')->with('error', 'Purchase returns cannot be updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        return redirect()->route('purchase-returns.index')->with('error', 'Purchase returns cannot be deleted.');
    }
}
