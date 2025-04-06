<?php
namespace App\Http\Controllers;

use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TrialBalanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $accounts = Account::where('is_active', true)
            ->with(['transactions' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function ($account) use ($startDate, $endDate) {
                $debit   = $account->getDebitAmount($startDate, $endDate);
                $credit  = $account->getCreditAmount($startDate, $endDate);
                $balance = $debit - $credit;

                return [
                    'id'      => $account->id,
                    'name'    => $account->name,
                    'type'    => $account->type,
                    'debit'   => $debit,
                    'credit'  => $credit,
                    'balance' => $balance,
                ];
            });

        $totalDebit   = $accounts->sum('debit');
        $totalCredit  = $accounts->sum('credit');
        $totalBalance = $totalDebit - $totalCredit;

        return view('account.trial_balance', compact(
            'accounts',
            'totalDebit',
            'totalCredit',
            'totalBalance',
            'startDate',
            'endDate'
        ));
    }

    public function download(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $accounts = Account::where('is_active', true)
            ->with(['transactions' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function ($account) use ($startDate, $endDate) {
                $debit   = $account->getDebitAmount($startDate, $endDate);
                $credit  = $account->getCreditAmount($startDate, $endDate);
                $balance = $debit - $credit;

                return [
                    'id'      => $account->id,
                    'name'    => $account->name,
                    'type'    => $account->type,
                    'debit'   => $debit,
                    'credit'  => $credit,
                    'balance' => $balance,
                ];
            });

        $totalDebit   = $accounts->sum('debit');
        $totalCredit  = $accounts->sum('credit');
        $totalBalance = $totalDebit - $totalCredit;

        $pdf = PDF::loadView('account.trial_balance_pdf', compact(
            'accounts',
            'totalDebit',
            'totalCredit',
            'totalBalance',
            'startDate',
            'endDate'
        ));

        return $pdf->download('trial-balance.pdf');
    }

    public function print(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $accounts = Account::where('is_active', true)
            ->with(['transactions' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function ($account) use ($startDate, $endDate) {
                $debit   = $account->getDebitAmount($startDate, $endDate);
                $credit  = $account->getCreditAmount($startDate, $endDate);
                $balance = $debit - $credit;

                return [
                    'id'      => $account->id,
                    'name'    => $account->name,
                    'type'    => $account->type,
                    'debit'   => $debit,
                    'credit'  => $credit,
                    'balance' => $balance,
                ];
            });

        $totalDebit   = $accounts->sum('debit');
        $totalCredit  = $accounts->sum('credit');
        $totalBalance = $totalDebit - $totalCredit;

        $pdf = PDF::loadView('account.trial_balance_pdf', compact(
            'accounts',
            'totalDebit',
            'totalCredit',
            'totalBalance',
            'startDate',
            'endDate'
        ));

        return $pdf->stream('trial-balance.pdf');
    }
}
