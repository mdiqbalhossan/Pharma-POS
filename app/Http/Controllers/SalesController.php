<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Sales;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Milon\Barcode\Facades\DNS2DFacade;

class SalesController extends Controller
{
    public function index()
    {
        $sales     = Sales::with('customer')->latest()->get();
        $customers = Customer::all();
        return view('sales.index', compact('sales', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'          => 'required',
            'sale_no'              => 'required',
            'sale_date'            => 'required',
            'total_amount'         => 'required',
            'amount_paid'          => 'required',
            'amount_due'           => 'required',
            'medicines'            => 'required|array',
            'medicines.*.id'       => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|numeric|min:1',
            'medicines.*.price'    => 'required|numeric|min:0',
            'medicines.*.total'    => 'required|numeric|min:0',
        ]);

        $status = $request->status;

        DB::beginTransaction();
        try {

            $saleExists = Sales::where('sale_no', $request->sale_no)->first();
            if (! $saleExists) {
                $sale = $this->salesAdded($request);
            } else {
                $sale = $this->salesUpdate($saleExists, $request);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $status === 'hold' ? 'Order has been placed on hold successfully' : 'Sale completed successfully',
                'data'    => $sale,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sales Added
     */

    private function salesAdded($request)
    {
        $sale = Sales::create([
            'sale_no'             => $request->sale_no,
            'sale_date'           => $request->sale_date,
            'customer_id'         => $request->customer_id,
            'tax_percentage'      => $request->tax_percentage,
            'discount_percentage' => $request->discount_percentage,
            'shipping_amount'     => $request->shipping_amount,
            'tax_amount'          => $request->tax_amount,
            'discount_amount'     => $request->discount_amount,
            'total_amount'        => $request->total_amount,
            'grand_total'         => $request->grand_total,
            'amount_paid'         => $request->amount_paid,
            'amount_due'          => $request->amount_due,
            'payment_method'      => $request->payment_method,
            'payment_status'      => $request->payment_status,
            'status'              => $request->status,
            'note'                => $request->note,
            'user_id'             => Auth::id(),
        ]);

        $medicines = $request->medicines;
        foreach ($medicines as $medicine) {
            $sale->medicines()->attach($medicine['id'], [
                'quantity' => $medicine['quantity'],
                'price'    => $medicine['price'],
                'total'    => $medicine['total'],
            ]);

            // Reduce medicine quantity if status is not 'hold'
            if ($request->status == 'success') {
                $medicineModel = Medicine::find($medicine['id']);
                if ($medicineModel) {
                    $medicineModel->quantity -= $medicine['quantity'];
                    $medicineModel->save();
                }
            }
        }

        return $sale;
    }

    /**
     * Sales Updated
     */
    private function salesUpdate($sale, $request)
    {
        // Get previous medicines and quantities before detaching
        $previousMedicines = $sale->medicines()->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->pivot->quantity];
        })->toArray();

        // Check if previous status was not 'hold' to handle quantity restoration
        $wasHold = $sale->status === 'hold';

        $sale->update([
            'sale_no'             => $request->sale_no,
            'sale_date'           => $request->sale_date,
            'customer_id'         => $request->customer_id,
            'tax_percentage'      => $request->tax_percentage,
            'discount_percentage' => $request->discount_percentage,
            'shipping_amount'     => $request->shipping_amount,
            'tax_amount'          => $request->tax_amount,
            'discount_amount'     => $request->discount_amount,
            'total_amount'        => $request->total_amount,
            'grand_total'         => $request->grand_total,
            'amount_paid'         => $request->amount_paid,
            'amount_due'          => $request->amount_due,
            'payment_method'      => $request->payment_method,
            'payment_status'      => $request->payment_status,
            'status'              => $request->status,
            'note'                => $request->note,
            'user_id'             => Auth::id(),
        ]);

        // If previous status was not 'hold', restore quantities before detaching
        if (! $wasHold) {
            foreach ($previousMedicines as $medicineId => $quantity) {
                $medicineModel = Medicine::find($medicineId);
                if ($medicineModel) {
                    $medicineModel->quantity += $quantity;
                    $medicineModel->save();
                }
            }
        }

        // Detach existing medicines
        $sale->medicines()->detach();

        $medicines = $request->medicines;
        foreach ($medicines as $medicine) {
            $sale->medicines()->attach($medicine['id'], [
                'quantity' => $medicine['quantity'],
                'price'    => $medicine['price'],
                'total'    => $medicine['total'],
            ]);

            // Reduce medicine quantity if current status is not 'hold'
            if ($request->status == 'success') {
                $medicineModel = Medicine::find($medicine['id']);
                if ($medicineModel) {
                    $medicineModel->quantity -= $medicine['quantity'];
                    $medicineModel->save();
                }
            }
        }

        return $sale;
    }

    // Get order details
    public function getOrderDetails($id)
    {
        try {
            $order = Sales::with(['customer', 'user', 'medicines'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $order,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
                'error'   => $e->getMessage(),
            ], 404);
        }
    }

    // Get order products
    public function getOrderProducts($id)
    {
        try {
            $order = Sales::with('medicines')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $order->medicines,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
                'error'   => $e->getMessage(),
            ], 404);
        }
    }

    // Get order receipt
    public function getOrderReceipt($id)
    {
        try {
            $order          = Sales::with(['customer', 'user', 'medicines'])->findOrFail($id);
            $barcode        = DNS2DFacade::getBarcodeHTML($order->sale_no, 'QRCODE', 2, 2, 'black');
            $order->barcode = $barcode;

            return response()->json([
                'success' => true,
                'data'    => $order,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
                'error'   => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sale)
    {
        $sale->load('customer', 'medicines', 'user');
        return view('sales.show', compact('sale'));
    }

    /**
     * Display the invoice for the sale.
     */
    public function invoice(Sales $sale)
    {
        $sale->load('customer', 'medicines', 'user');
        $barcode       = DNS2DFacade::getBarcodeHTML($sale->sale_no, 'QRCODE', 2, 2, 'black');
        $sale->barcode = $barcode;
        return view('sales.invoice', compact('sale'));
    }

    /**
     * Download the invoice as PDF.
     */
    public function downloadInvoice(Sales $sale)
    {
        $sale->load('customer', 'medicines', 'user');
        $barcode       = DNS2DFacade::getBarcodeHTML($sale->sale_no, 'QRCODE', 2, 2, 'black');
        $sale->barcode = $barcode;

        // Generate PDF using DomPDF
        $pdf = PDF::loadView('sales.invoice', compact('sale'));

        // Set filename
        $filename = 'sale_invoice_' . $sale->sale_no . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }
}
