<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Supplier;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Purchase Data
        $totalPurchaseDue = Purchase::sum('due_amount');

        // Sales Data
        $totalSalesDue   = Sales::sum('amount_due');
        $totalSaleAmount = Sales::sum('grand_total');

        // Expense Data
        $totalExpenseAmount = Expense::sum('amount');

        // Count Data
        $customerCount        = Customer::count();
        $supplierCount        = Supplier::count();
        $purchaseInvoiceCount = Purchase::count();
        $salesInvoiceCount    = Sales::count();

        // Monthly Sales & Purchase Data for Chart
        $currentYear      = date('Y');
        $monthlySales     = $this->getMonthlySalesData($currentYear);
        $monthlyPurchases = $this->getMonthlyPurchaseData($currentYear);

        // Recent Products
        $recentProducts = Medicine::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Expired Products
        $expiredProducts = Medicine::where('expiration_date', '<', Carbon::now())
            ->orderBy('expiration_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPurchaseDue',
            'totalSalesDue',
            'totalSaleAmount',
            'totalExpenseAmount',
            'customerCount',
            'supplierCount',
            'purchaseInvoiceCount',
            'salesInvoiceCount',
            'monthlySales',
            'monthlyPurchases',
            'recentProducts',
            'expiredProducts'
        ));
    }

    /**
     * Get monthly sales data for chart
     */
    private function getMonthlySalesData($year)
    {
        $monthlySales = Sales::selectRaw('MONTH(sale_date) as month, SUM(grand_total) as total')
            ->whereYear('sale_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $monthlySales[$i] ?? 0;
        }

        return $data;
    }

    /**
     * Get monthly purchase data for chart
     */
    private function getMonthlyPurchaseData($year)
    {
        $monthlyPurchases = Purchase::selectRaw('MONTH(date) as month, SUM(grand_total) as total')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $monthlyPurchases[$i] ?? 0;
        }

        return $data;
    }
}
