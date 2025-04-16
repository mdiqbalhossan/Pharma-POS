<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Trait\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    use Transaction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with('expenseCategory')->latest()->get();
        return view('expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenseCategories = ExpenseCategory::all();
        $accounts          = Account::all();
        return view('expense.create', compact('expenseCategories', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'date'                => 'required|date',
            'expense_for'         => 'required|string|max:255',
            'amount'              => 'required|numeric|min:0',
            'description'         => 'nullable|string',
            'reference'           => 'nullable|string|max:255',
            'account_id'          => 'required|exists:accounts,id',
        ]);

        DB::beginTransaction();
        try {
            $expense = Expense::create($validated);

            $this->saveTransaction([
                'account_id'       => $validated['account_id'],
                'type'             => 'debit',
                'amount'           => $validated['amount'],
                'transaction_date' => $validated['date'],
                'description'      => $validated['description'],
            ]);
            DB::commit();
            return redirect()->route('expenses.index')
                ->with('success', 'Expense created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('expenses.index')
                ->with('error', 'Expense creation failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $expense->load('expenseCategory');
        return view('expense.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $expenseCategories = ExpenseCategory::all();
        $accounts          = Account::all();
        return view('expense.edit', compact('expense', 'expenseCategories', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'date'                => 'required|date',
            'expense_for'         => 'required|string|max:255',
            'amount'              => 'required|numeric|min:0',
            'description'         => 'nullable|string',
            'reference'           => 'nullable|string|max:255',
            'account_id'          => 'required|exists:accounts,id',
        ]);

        DB::beginTransaction();
        try {
            $expense->update($validated);

            $this->updateTransaction([
                'account_id'       => $validated['account_id'],
                'type'             => 'debit',
                'amount'           => $validated['amount'],
                'transaction_date' => $validated['date'],
                'description'      => $validated['description'],
            ]);
            DB::commit();
            return redirect()->route('expenses.index')
                ->with('success', 'Expense updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('expenses.index')
                ->with('error', 'Expense update failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
