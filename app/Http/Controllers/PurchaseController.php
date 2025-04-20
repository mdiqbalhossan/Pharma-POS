<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Trait\Transaction;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    use Transaction;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest()->get();
        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers     = Supplier::all();
        $invoiceNumber = Purchase::getInvoiceNumber();
        $accounts      = Account::all();
        return view('purchase.create', compact('suppliers', 'invoiceNumber', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'supplier_id'    => 'required|exists:suppliers,id',
            'date'           => 'required|date',
            'purchase_type'  => 'required|string|in:purchase,purchase_order',
            'payment_method' => 'required|string',
            'medicine_id'    => 'required|array',
            'medicine_id.*'  => 'required|exists:medicines,id',
            'batch_no'       => 'required|array',
            'batch_no.*'     => 'required|string',
            'expiry_date'    => 'required|array',
            'expiry_date.*'  => 'required|date',
            'quantity'       => 'required|array',
            'quantity.*'     => 'required|numeric|min:1',
            'unit_price'     => 'required|array',
            'unit_price.*'   => 'required|numeric|min:0',
            'discount'       => 'nullable|array',
            'discount.*'     => 'nullable|numeric|min:0',
            'order_tax'      => 'nullable|numeric|min:0',
            'order_discount' => 'nullable|numeric|min:0',
            'shipping_cost'  => 'nullable|numeric|min:0',
            'grand_total'    => 'required|numeric|min:0',
            'paid_amount'    => 'required|numeric|min:0',
            'note'           => 'nullable|string',
            'account_id'     => 'required',
        ]);

        try {
            DB::beginTransaction();
            $invoicePrefix = setting('invoice_prefix') ?? 'INV-';
            // Generate reference number if not provided
            if (empty($request->invoice_no)) {
                $latestPurchase = Purchase::latest('id')->first();
                $invoiceNo      = $invoicePrefix . date('Ymd') . '-' . sprintf('%04d', ($latestPurchase ? $latestPurchase->id + 1 : 1));
            } else {
                $invoiceNo = $request->invoice_no;
            }

            // Calculate due amount
            $dueAmount = $request->grand_total - $request->paid_amount;

            // Create purchase
            $purchase = Purchase::create([
                'invoice_no'     => $invoiceNo,
                'type'           => $request->purchase_type,
                'supplier_id'    => $request->supplier_id,
                'date'           => Carbon::parse($request->date)->format('Y-m-d'),
                'subtotal'       => $request->subtotal,
                'discount'       => $request->discount_amount ?? 0,
                'tax'            => $request->order_tax ?? 0,
                'total_tax'      => $request->tax_amount ?? 0,
                'shipping'       => $request->shipping_cost ?? 0,
                'grand_total'    => $request->grand_total,
                'paid_amount'    => $request->paid_amount,
                'due_amount'     => $dueAmount,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
                'account_id'     => $request->account_id,
            ]);

            // Add medicines to purchase
            $medicines    = $request->medicine_id;
            $batchNumbers = $request->batch_no;
            $expiryDates  = $request->expiry_date;
            $quantities   = $request->quantity;
            $unitPrices   = $request->unit_price;
            $discounts    = $request->discount;
            $rowTotals    = $request->row_total;

            for ($i = 0; $i < count($medicines); $i++) {
                // Attach medicine to purchase
                $purchase->medicines()->attach($medicines[$i], [
                    'batch_no'    => $batchNumbers[$i],
                    'expiry_date' => Carbon::parse($expiryDates[$i])->format('Y-m-d'),
                    'quantity'    => $quantities[$i],
                    'unit_price'  => $unitPrices[$i],
                    'discount'    => $discounts[$i] ?? 0,
                    'total_price' => $unitPrices[$i] * $quantities[$i],
                    'grand_total' => $rowTotals[$i],
                    'tax'         => $request->tax[$i] ?? 0,
                    'total_tax'   => $request->tax_amount[$i] ?? 0,
                ]);
                if ($request->purchase_type == 'purchase') {
                    // Update medicine stock
                    $medicine = Medicine::find($medicines[$i]);
                    $medicine->quantity += $quantities[$i];
                    $medicine->save();
                }
            }

            $this->saveTransaction([
                'account_id'       => $request->account_id,
                'type'             => 'debit',
                'amount'           => $request->grand_total,
                'transaction_date' => Carbon::parse($request->date)->format('Y-m-d'),
                'description'      => $request->note,
            ]);

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Purchase created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating purchase: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'medicines');
        return view('purchase.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $purchase->load('supplier', 'medicines');
        $suppliers = Supplier::all();
        $accounts  = Account::all();
        return view('purchase.edit', compact('purchase', 'suppliers', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        // dd($request->all());
        // Validate request
        $request->validate([
            'supplier_id'    => 'required|exists:suppliers,id',
            'date'           => 'required|date',
            'payment_method' => 'required|string',
            'medicine_id'    => 'required|array',
            'medicine_id.*'  => 'required|exists:medicines,id',
            'batch_no'       => 'required|array',
            'batch_no.*'     => 'required|string',
            'expiry_date'    => 'required|array',
            'expiry_date.*'  => 'required|date',
            'quantity'       => 'required|array',
            'quantity.*'     => 'required|numeric|min:1',
            'unit_price'     => 'required|array',
            'unit_price.*'   => 'required|numeric|min:0',
            'discount'       => 'nullable|array',
            'discount.*'     => 'nullable|numeric|min:0',
            'order_tax'      => 'nullable|numeric|min:0',
            'order_discount' => 'nullable|numeric|min:0',
            'shipping_cost'  => 'nullable|numeric|min:0',
            'grand_total'    => 'required|numeric|min:0',
            'paid_amount'    => 'required|numeric|min:0',
            'note'           => 'nullable|string',
            'account_id'     => 'required|exists:accounts,id',
        ]);

        try {
            DB::beginTransaction();

            // Calculate due amount
            $dueAmount = $request->grand_total - $request->paid_amount;

            // Update purchase
            $purchase->update([
                'supplier_id'    => $request->supplier_id,
                'date'           => Carbon::parse($request->date)->format('Y-m-d'),
                'subtotal'       => $request->subtotal,
                'discount'       => $request->order_discount ?? 0,
                'tax'            => $request->order_tax ?? 0,
                'total_tax'      => $request->tax_amount ?? 0,
                'shipping'       => $request->shipping_cost ?? 0,
                'grand_total'    => $request->grand_total,
                'paid_amount'    => $request->paid_amount,
                'due_amount'     => $dueAmount,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
                'account_id'     => $request->account_id,
            ]);

            // Update medicines
            $medicines    = $request->medicine_id;
            $batchNumbers = $request->batch_no;
            $expiryDates  = $request->expiry_date;
            $quantities   = $request->quantity;
            $unitPrices   = $request->unit_price;
            $discounts    = $request->discount;
            $rowTotals    = $request->row_total;

            // Detach existing medicines
            $purchase->medicines()->detach();
            // Attach new medicines
            for ($i = 0; $i < count($medicines); $i++) {

                // Attach medicine to purchase
                $purchase->medicines()->attach($medicines[$i], [
                    'batch_no'    => $batchNumbers[$i],
                    'expiry_date' => Carbon::parse($expiryDates[$i])->format('Y-m-d'),
                    'quantity'    => $quantities[$i],
                    'unit_price'  => $unitPrices[$i],
                    'discount'    => $discounts[$i] ?? 0,
                    'total_price' => $unitPrices[$i] * $quantities[$i],
                    'grand_total' => $rowTotals[$i],
                    'tax'         => $request->tax[$i] ?? 0,
                    'total_tax'   => $request->total_tax[$i] ?? 0,
                ]);
                if ($request->purchase_type == 'purchase') {
                    // Update medicine stock
                    $medicine = Medicine::find($medicines[$i]);
                    $medicine->quantity += $quantities[$i];
                    $medicine->save();
                }
            }

            $this->updateTransaction([
                'id'               => $purchase->id,
                'account_id'       => $request->account_id,
                'type'             => 'debit',
                'amount'           => $request->grand_total,
                'transaction_date' => Carbon::parse($request->date)->format('Y-m-d'),
                'description'      => $request->note,
            ]);
            log_message('error', DB::getQueryLog());
            DB::commit();
            return redirect()->route('purchases.index')
                ->with('success', 'Purchase updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage() . ' ' . $e->getTraceAsString() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return redirect()->back()
                ->with('error', 'Error updating purchase: ' . $e->getMessage() . ' ' . $e->getTraceAsString())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        try {
            DB::beginTransaction();

            // Revert stock quantities
            foreach ($purchase->medicines as $medicine) {
                $medicine->quantity -= $medicine->pivot->quantity;
                $medicine->save();
            }

            // Delete purchase
            $purchase->medicines()->detach();
            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Purchase deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error deleting purchase: ' . $e->getMessage());
        }
    }

    /**
     * Display the invoice for the purchase.
     */
    public function invoice(Purchase $purchase)
    {
        $purchase->load('supplier', 'medicines');
        return view('purchase.invoice', compact('purchase'));
    }

    /**
     * Download the invoice as PDF.
     */
    public function downloadInvoice(Purchase $purchase)
    {
        $purchase->load('supplier', 'medicines');
        $extra_css = '.no-print {
                display: none;
            }

            .m-0 {
                margin: 0;
            }

            body {
                padding: 0;
                margin: 0;
            }

            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 10px;
                max-width: 100%;
            }

            .totals-row {
                margin-bottom: 10px;
                padding-bottom: 20px;
            }

            .clear {
                clear: both;
                height: 0;
                overflow: hidden;
            }

            .logo-img {
                margin-bottom: 20px;
            }
        ';

        $logo = photo_url_pdf(setting('invoice_logo'));
        // Generate PDF using a PDF library like DomPDF
        $pdf = PDF::loadView('purchase.invoice-pdf', compact('purchase', 'extra_css', 'logo'));

        // Set filename
        $filename = 'purchase_invoice_' . $purchase->invoice_no . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }

    /**
     * Get purchase details for AJAX request.
     */
    public function getDetails(Purchase $purchase)
    {
        try {
            $purchase->load(['supplier', 'medicines']);

            // Return JSON response
            return response()->json([
                'success' => true,
                'data'    => [
                    'purchase'  => $purchase,
                    'medicines' => $purchase->medicines,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading purchase details: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Convert purchase order to purchase.
     */
    public function convertPurchaseOrder(Request $request, Purchase $purchase)
    {
        try {
            // Validate request
            $request->validate([
                'received_quantities'   => 'required|array',
                'received_quantities.*' => 'required|numeric|min:0',
            ]);

            // Check if purchase is already converted
            if ($purchase->type !== 'purchase_order') {
                return response()->json([
                    'success' => false,
                    'message' => 'This is not a purchase order or has already been converted.',
                ]);
            }

            DB::beginTransaction();

            // Update purchase type to 'purchase'
            $purchase->type = 'purchase';
            $purchase->save();

            // Update medicine stock based on received quantities
            foreach ($request->received_quantities as $medicineId => $receivedQty) {
                $medicine = Medicine::find($medicineId);

                if ($medicine) {
                    // Update medicine stock
                    $medicine->quantity += $receivedQty;
                    $medicine->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase order converted to purchase successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error converting purchase order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Purchase order
     */
    public function purchaseOrder()
    {
        $purchase = Purchase::where('type', 'purchase_order')->get();
        return view('purchase.purchase-order', compact('purchase'));
    }
}
