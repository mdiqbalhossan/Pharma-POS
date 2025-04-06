<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Supplier;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the sales report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function salesReport(Request $request)
    {
        $query = Sales::with('customer');

        // Apply date filters if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date   = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('sale_date', [$start_date, $end_date]);
        }

        // Filter by customer if provided
        if ($request->filled('customer_id') && $request->customer_id != 'all') {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'paid') {
                $query->whereRaw('amount_due <= 0');
            } elseif ($request->payment_status == 'partial') {
                $query->whereRaw('amount_paid > 0 AND amount_due > 0');
            } elseif ($request->payment_status == 'unpaid') {
                $query->whereRaw('amount_paid <= 0');
            }
        }

        $sales     = $query->orderBy('sale_date', 'desc')->get();
        $customers = Customer::all();

        // Calculate totals
        $totalSales = $sales->sum('grand_total');
        $totalPaid  = $sales->sum('amount_paid');
        $totalDue   = $sales->sum('amount_due');

        return view('reports.sales_report', compact('sales', 'customers', 'totalSales', 'totalPaid', 'totalDue'));
    }

    /**
     * Display the purchase report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function purchaseReport(Request $request)
    {
        $query = Purchase::with('supplier');

        // Apply date filters if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date   = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('date', [$start_date, $end_date]);
        }

        // Filter by supplier if provided
        if ($request->filled('supplier_id') && $request->supplier_id != 'all') {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            if ($request->payment_status == 'paid') {
                $query->whereRaw('amount_due <= 0');
            } elseif ($request->payment_status == 'partial') {
                $query->whereRaw('amount_paid > 0 AND amount_due > 0');
            } elseif ($request->payment_status == 'unpaid') {
                $query->whereRaw('amount_paid <= 0');
            }
        }

        $purchases = $query->orderBy('date', 'desc')->get();
        $suppliers = Supplier::all();

        // Calculate totals
        $totalPurchases = $purchases->sum('grand_total');
        $totalPaid      = $purchases->sum('amount_paid');
        $totalDue       = $purchases->sum('amount_due');

        return view('reports.purchase_report', compact('purchases', 'suppliers', 'totalPurchases', 'totalPaid', 'totalDue'));
    }

    /**
     * Display the inventory report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inventoryReport(Request $request)
    {
        $query = Medicine::with(['medicine_categories', 'unit', 'medicine_type']);

        // Filter by category if provided
        if ($request->filled('category_id')) {
            $query->where('medicine_category_id', $request->category_id);
        }

        // Filter by type if provided
        if ($request->filled('type_id')) {
            $query->where('medicine_type_id', $request->type_id);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'in_stock') {
                $query->where('quantity', '>', 0);
            } elseif ($request->stock_status == 'out_of_stock') {
                $query->where('quantity', '<=', 0);
            } elseif ($request->stock_status == 'low_stock') {
                $query->whereRaw('quantity > 0 AND quantity <= alert_qty');
            }
        }

        $medicines = $query->orderBy('name')->get();

        // Calculate inventory value
        $totalInventoryValue = $medicines->sum(function ($medicine) {
            return $medicine->quantity * $medicine->sale_price;
        });

        $totalInventoryCost = $medicines->sum(function ($medicine) {
            return $medicine->quantity * $medicine->purchase_price;
        });

        return view('reports.inventory_report', compact('medicines', 'totalInventoryValue', 'totalInventoryCost'));
    }

    /**
     * Display the invoice report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invoiceReport(Request $request)
    {
        $query = Sales::with(['customer']);

        // Apply date filters if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date   = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('sale_date', [$start_date, $end_date]);
        }

        // Filter by invoice number if provided
        if ($request->filled('invoice_no')) {
            $query->where('sale_no', 'like', '%' . $request->invoice_no . '%');
        }

        // Filter by customer if provided
        if ($request->filled('customer_id') && $request->customer_id != 'all') {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices  = $query->orderBy('sale_date', 'desc')->get();
        $customers = Customer::all();

        return view('reports.invoice_report', compact('invoices', 'customers'));
    }

    /**
     * Display the supplier report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function supplierReport(Request $request)
    {
        $query = Supplier::with('purchases');

        // Filter by supplier if provided
        if ($request->filled('supplier_id') && $request->supplier_id != 'all') {
            $query->where('id', $request->supplier_id);
        }

        $suppliers = $query->get();

        // Calculate supplier metrics
        foreach ($suppliers as $supplier) {
            $purchaseQuery = Purchase::where('supplier_id', $supplier->id);

            // Apply date filters if provided
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start_date = Carbon::parse($request->start_date)->startOfDay();
                $end_date   = Carbon::parse($request->end_date)->endOfDay();
                $purchaseQuery->whereBetween('date', [$start_date, $end_date]);
            }

            $purchases = $purchaseQuery->get();

            $supplier->total_purchases = $purchases->sum('grand_total');
            $supplier->total_paid      = $purchases->sum('paid_amount');
            $supplier->total_due       = $purchases->sum('due_amount');
            $supplier->purchase_count  = $purchases->count();
        }

        return view('reports.supplier_report', compact('suppliers'));
    }

    /**
     * Display the customer report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function customerReport(Request $request)
    {
        $query = Customer::with('sales');

        // Filter by customer if provided
        if ($request->filled('customer_id') && $request->customer_id != 'all') {
            $query->where('id', $request->customer_id);
        }

        $customers = $query->get();

        // Calculate customer metrics
        foreach ($customers as $customer) {
            $salesQuery = Sales::where('customer_id', $customer->id);

            // Apply date filters if provided
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $start_date = Carbon::parse($request->start_date)->startOfDay();
                $end_date   = Carbon::parse($request->end_date)->endOfDay();
                $salesQuery->whereBetween('sale_date', [$start_date, $end_date]);
            }

            $sales = $salesQuery->get();

            $customer->total_sales = $sales->sum('grand_total');
            $customer->total_paid  = $sales->sum('amount_paid');
            $customer->total_due   = $sales->sum('amount_due');
            $customer->sale_count  = $sales->count();
        }

        return view('reports.customer_report', compact('customers'));
    }

    /**
     * Display the expense report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function expenseReport(Request $request)
    {
        $query = Expense::with('expenseCategory');

        // Apply date filters if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date   = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('date', [$start_date, $end_date]);
        }

        // Filter by category if provided
        if ($request->filled('category_id') && $request->category_id != 'all') {
            $query->where('expense_category_id', $request->category_id);
        }

        $expenses     = $query->orderBy('date', 'desc')->get();
        $categories   = ExpenseCategory::all();
        $totalExpense = $expenses->sum('amount');

        return view('reports.expense_report', compact('expenses', 'categories', 'totalExpense'));
    }

    /**
     * Display the income report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function incomeReport(Request $request)
    {
        // Initialize date filters
        $start_date = null;
        $end_date   = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date   = Carbon::parse($request->end_date)->endOfDay();
        }

        // Get sales income
        $salesQuery = Sales::query();
        if ($start_date && $end_date) {
            $salesQuery->whereBetween('sale_date', [$start_date, $end_date]);
        }
        $sales       = $salesQuery->get();
        $salesIncome = $sales->sum('amount_paid');

        // Get other income transactions
        $incomeQuery = Transaction::where('type', 'income');
        if ($start_date && $end_date) {
            $incomeQuery->whereBetween('transaction_date', [$start_date, $end_date]);
        }
        $otherIncome = $incomeQuery->sum('amount');

        // Total income
        $totalIncome = $salesIncome + $otherIncome;

        // Get income by date for chart
        $incomeByDate = [];

        if ($start_date && $end_date) {
            $period = Carbon::parse($start_date)->daysUntil($end_date);

            foreach ($period as $date) {
                $dateStr     = $date->format('Y-m-d');
                $saleAmount  = Sales::whereDate('sale_date', $dateStr)->sum('amount_paid');
                $otherAmount = Transaction::where('type', 'income')
                    ->whereDate('transaction_date', $dateStr)
                    ->sum('amount');

                $incomeByDate[$dateStr] = [
                    'date'  => $date->format('d M Y'),
                    'sales' => $saleAmount,
                    'other' => $otherAmount,
                    'total' => $saleAmount + $otherAmount,
                ];
            }
        }

        return view('reports.income_report', compact('salesIncome', 'otherIncome', 'totalIncome', 'incomeByDate'));
    }

    /**
     * Display the tax report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function taxReport(Request $request)
    {
        // Initialize date filters
        $start_date = null;
        $end_date   = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date   = Carbon::parse($request->end_date)->endOfDay();
        }

        // Get sales tax
        $salesQuery = Sales::query();
        if ($start_date && $end_date) {
            $salesQuery->whereBetween('sale_date', [$start_date, $end_date]);
        }
        $sales    = $salesQuery->get();
        $salesTax = $sales->sum('tax_amount');

        // Get purchase tax
        $purchaseQuery = Purchase::query();
        if ($start_date && $end_date) {
            $purchaseQuery->whereBetween('date', [$start_date, $end_date]);
        }
        $purchases   = $purchaseQuery->get();
        $purchaseTax = $purchases->sum('tax_amount');

        // Calculate net tax
        $netTax = $salesTax - $purchaseTax;

        // Get tax by month for chart
        $taxByMonth = [];

        if ($start_date && $end_date) {
            $period = Carbon::parse($start_date)->monthsUntil($end_date);

            foreach ($period as $date) {
                $monthStart = $date->copy()->startOfMonth();
                $monthEnd   = $date->copy()->endOfMonth();

                $monthSalesTax    = Sales::whereBetween('sale_date', [$monthStart, $monthEnd])->sum('tax_amount');
                $monthPurchaseTax = Purchase::whereBetween('date', [$monthStart, $monthEnd])->sum('tax_amount');

                $taxByMonth[$date->format('Y-m')] = [
                    'month'        => $date->format('M Y'),
                    'sales_tax'    => $monthSalesTax,
                    'purchase_tax' => $monthPurchaseTax,
                    'net_tax'      => $monthSalesTax - $monthPurchaseTax,
                ];
            }
        }

        return view('reports.tax_report', compact('salesTax', 'purchaseTax', 'netTax', 'taxByMonth'));
    }

    /**
     * Display the profit and loss report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profitLossReport(Request $request)
    {
        // Initialize date filters with default as current month
        $start_date = $request->filled('start_date')
        ? Carbon::parse($request->start_date)->startOfDay()
        : Carbon::now()->startOfMonth();

        $end_date = $request->filled('end_date')
        ? Carbon::parse($request->end_date)->endOfDay()
        : Carbon::now()->endOfMonth();

        // INCOME SECTION

        // Sales revenue
        $sales        = Sales::whereBetween('sale_date', [$start_date, $end_date])->get();
        $salesRevenue = $sales->sum('grand_total');

        // Other income
        $otherIncome = Transaction::where('type', 'income')
            ->whereBetween('transaction_date', [$start_date, $end_date])
            ->sum('amount');

        // Total income
        $totalIncome = $salesRevenue + $otherIncome;

        // EXPENSE SECTION

        // Cost of goods sold (from purchase)
        $purchases       = Purchase::whereBetween('date', [$start_date, $end_date])->get();
        $costOfGoodsSold = $purchases->sum('grand_total');

        // Direct expenses (from expense categories marked as direct)
        $directExpenses = Expense::whereHas('expenseCategory')
            ->whereBetween('date', [$start_date, $end_date])
            ->sum('amount');

        // Indirect expenses (from expense categories marked as indirect)
        $indirectExpenses = Expense::whereHas('expenseCategory', function ($query) {
            $query->where('expense_for', false);
        })
            ->whereBetween('date', [$start_date, $end_date])
            ->sum('amount');

        // Total expenses
        $totalExpenses = $costOfGoodsSold + $directExpenses + $indirectExpenses;

        // PROFIT CALCULATIONS

        // Gross profit
        $grossProfit = $salesRevenue - ($costOfGoodsSold + $directExpenses);

        // Net profit
        $netProfit = $totalIncome - $totalExpenses;

        return view('reports.profit_loss_report', compact(
            'start_date',
            'end_date',
            'salesRevenue',
            'otherIncome',
            'totalIncome',
            'costOfGoodsSold',
            'directExpenses',
            'indirectExpenses',
            'totalExpenses',
            'grossProfit',
            'netProfit'
        ));
    }
}
