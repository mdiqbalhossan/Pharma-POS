<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to current month
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get revenue accounts (income type)
        $revenueAccounts = Account::whereIn('type', ['asset', 'income'])->get();

        // Get expense accounts
        $expenseAccounts = Account::whereIn('type', ['liability', 'equity', 'expense'])->get();

        // Calculate total revenue
        $totalRevenue = $revenueAccounts->sum(function ($account) use ($startDate, $endDate) {
            return $this->getAccountBalance($account->id, $startDate, $endDate);
        });

        // Calculate total expenses
        $totalExpenses = $expenseAccounts->sum(function ($account) use ($startDate, $endDate) {
            return $this->getAccountBalance($account->id, $startDate, $endDate);
        });

        // Calculate net income
        $netIncome = $totalRevenue - $totalExpenses;

        // Get detailed revenue breakdown
        $revenueBreakdown = $revenueAccounts->map(function ($account) use ($startDate, $endDate) {
            return [
                'name'   => $account->name,
                'amount' => $this->getAccountBalance($account->id, $startDate, $endDate),
            ];
        });

        // Get detailed expense breakdown
        $expenseBreakdown = $expenseAccounts->map(function ($account) use ($startDate, $endDate) {
            return [
                'name'   => $account->name,
                'amount' => $this->getAccountBalance($account->id, $startDate, $endDate),
            ];
        });

        return view('account.income_statement', compact(
            'startDate',
            'endDate',
            'revenueBreakdown',
            'expenseBreakdown',
            'totalRevenue',
            'totalExpenses',
            'netIncome'
        ));
    }

    public function print(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get the same data as index method
        $revenueAccounts = Account::where('type', 'income')->get();
        $expenseAccounts = Account::where('type', 'expense')->get();

        $totalRevenue = $revenueAccounts->sum(function ($account) use ($startDate, $endDate) {
            return $this->getAccountBalance($account->id, $startDate, $endDate);
        });

        $totalExpenses = $expenseAccounts->sum(function ($account) use ($startDate, $endDate) {
            return $this->getAccountBalance($account->id, $startDate, $endDate);
        });

        $netIncome = $totalRevenue - $totalExpenses;

        $revenueBreakdown = $revenueAccounts->map(function ($account) use ($startDate, $endDate) {
            return [
                'name'   => $account->name,
                'amount' => $this->getAccountBalance($account->id, $startDate, $endDate),
            ];
        });

        $expenseBreakdown = $expenseAccounts->map(function ($account) use ($startDate, $endDate) {
            return [
                'name'   => $account->name,
                'amount' => $this->getAccountBalance($account->id, $startDate, $endDate),
            ];
        });

        return view('account.income_statement_print', compact(
            'startDate',
            'endDate',
            'revenueBreakdown',
            'expenseBreakdown',
            'totalRevenue',
            'totalExpenses',
            'netIncome'
        ));
    }

    public function download(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get the same data as index method
        $revenueAccounts = Account::where('type', 'income')->get();
        $expenseAccounts = Account::where('type', 'expense')->get();

        $totalRevenue = $revenueAccounts->sum(function ($account) use ($startDate, $endDate) {
            return $this->getAccountBalance($account->id, $startDate, $endDate);
        });

        $totalExpenses = $expenseAccounts->sum(function ($account) use ($startDate, $endDate) {
            return $this->getAccountBalance($account->id, $startDate, $endDate);
        });

        $netIncome = $totalRevenue - $totalExpenses;

        $revenueBreakdown = $revenueAccounts->map(function ($account) use ($startDate, $endDate) {
            return [
                'name'   => $account->name,
                'amount' => $this->getAccountBalance($account->id, $startDate, $endDate),
            ];
        });

        $expenseBreakdown = $expenseAccounts->map(function ($account) use ($startDate, $endDate) {
            return [
                'name'   => $account->name,
                'amount' => $this->getAccountBalance($account->id, $startDate, $endDate),
            ];
        });

        $pdf = PDF::loadView('account.income_statement_print', compact(
            'startDate',
            'endDate',
            'revenueBreakdown',
            'expenseBreakdown',
            'totalRevenue',
            'totalExpenses',
            'netIncome'
        ));

        return $pdf->download('income-statement.pdf');
    }

    private function getAccountBalance($accountId, $startDate, $endDate)
    {
        return Transaction::where('account_id', $accountId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');
    }
}
