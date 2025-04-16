<?php
namespace App\Http\Controllers;

use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate   = $request->get('end_date', date('Y-m-d'));

        // Get all accounts with their balances
        $accounts = Account::with(['transactions' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }])->get();

        // Calculate balances for each account
        $accountBalances = [];
        $typeTotals      = [
            'asset'     => 0,
            'liability' => 0,
            'equity'    => 0,
            'revenue'   => 0,
            'expense'   => 0,
        ];

        foreach ($accounts as $account) {
            $debit   = $account->getDebitAmount($startDate, $endDate);
            $credit  = $account->getCreditAmount($startDate, $endDate);
            $balance = $credit - $debit;

            // For liability and equity accounts, reverse the balance
            if (in_array($account->type, ['liability', 'equity'])) {
                $balance = -$balance;
            }

            $accountBalances[] = [
                'name'    => $account->name,
                'type'    => $account->type,
                'debit'   => $debit,
                'credit'  => $credit,
                'balance' => $balance,
            ];

            // Add to type totals
            $typeTotals[$account->type == 'income' ? 'revenue' : $account->type] += $balance;
        }

        // Calculate total assets and liabilities
        $totalAssets               = $typeTotals['asset'];
        $totalLiabilities          = $typeTotals['liability'];
        $totalEquity               = $typeTotals['equity'];
        $netIncome                 = $typeTotals['revenue'] - $typeTotals['expense'];
        $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity + $netIncome;

        return view('account.balance_sheet', compact(
            'accountBalances',
            'typeTotals',
            'totalAssets',
            'totalLiabilities',
            'totalEquity',
            'netIncome',
            'totalLiabilitiesAndEquity',
            'startDate',
            'endDate'
        ));
    }

    public function print(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate   = $request->get('end_date', date('Y-m-d'));

        // Get all accounts with their balances
        $accounts = Account::with(['transactions' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }])->get();

        // Calculate balances for each account
        $accountBalances = [];
        $typeTotals      = [
            'asset'     => 0,
            'liability' => 0,
            'equity'    => 0,
            'revenue'   => 0,
            'expense'   => 0,
        ];

        foreach ($accounts as $account) {
            $debit   = $account->getDebitAmount($startDate, $endDate);
            $credit  = $account->getCreditAmount($startDate, $endDate);
            $balance = $credit - $debit;

            if (in_array($account->type, ['liability', 'equity'])) {
                $balance = -$balance;
            }

            $accountBalances[] = [
                'name'    => $account->name,
                'type'    => $account->type,
                'debit'   => $debit,
                'credit'  => $credit,
                'balance' => $balance,
            ];

            $typeTotals[$account->type] += $balance;
        }

        $totalAssets               = $typeTotals['asset'];
        $totalLiabilities          = $typeTotals['liability'];
        $totalEquity               = $typeTotals['equity'];
        $netIncome                 = $typeTotals['revenue'] - $typeTotals['expense'];
        $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity + $netIncome;

        return view('account.balance_sheet_print', compact(
            'accountBalances',
            'typeTotals',
            'totalAssets',
            'totalLiabilities',
            'totalEquity',
            'netIncome',
            'totalLiabilitiesAndEquity',
            'startDate',
            'endDate'
        ));
    }

    public function download(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate   = $request->get('end_date', date('Y-m-d'));

        // Get all accounts with their balances
        $accounts = Account::with(['transactions' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }])->get();

        // Calculate balances for each account
        $accountBalances = [];
        $typeTotals      = [
            'asset'     => 0,
            'liability' => 0,
            'equity'    => 0,
            'revenue'   => 0,
            'expense'   => 0,
        ];

        foreach ($accounts as $account) {
            $debit   = $account->getDebitAmount($startDate, $endDate);
            $credit  = $account->getCreditAmount($startDate, $endDate);
            $balance = $credit - $debit;

            if (in_array($account->type, ['liability', 'equity'])) {
                $balance = -$balance;
            }

            $accountBalances[] = [
                'name'    => $account->name,
                'type'    => $account->type,
                'debit'   => $debit,
                'credit'  => $credit,
                'balance' => $balance,
            ];

            $typeTotals[$account->type] += $balance;
        }

        $totalAssets               = $typeTotals['asset'];
        $totalLiabilities          = $typeTotals['liability'];
        $totalEquity               = $typeTotals['equity'];
        $netIncome                 = $typeTotals['revenue'] - $typeTotals['expense'];
        $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity + $netIncome;

        $pdf = PDF::loadView('account.balance_sheet_pdf', compact(
            'accountBalances',
            'typeTotals',
            'totalAssets',
            'totalLiabilities',
            'totalEquity',
            'netIncome',
            'totalLiabilitiesAndEquity',
            'startDate',
            'endDate'
        ));

        return $pdf->download('balance-sheet.pdf');
    }
}
