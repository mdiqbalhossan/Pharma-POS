<?php
namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('account')
            ->latest()
            ->get();
        return view('transaction.index', compact('transactions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('account');
        return view('transaction.show', compact('transaction'));
    }
}
