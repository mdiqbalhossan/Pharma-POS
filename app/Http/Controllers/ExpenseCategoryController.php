<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseCategories = ExpenseCategory::latest()->get();
        return view('expense_category.index', compact('expenseCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expense_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories',
            'description' => 'nullable|string'
        ]);

        ExpenseCategory::create($request->all());

        return redirect()->route('expense-categories.index')
            ->with('success', 'Expense category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('expense_category.edit', compact('expenseCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name,' . $expenseCategory->id,
            'description' => 'nullable|string'
        ]);

        $expenseCategory->update($request->all());

        return redirect()->route('expense-categories.index')
            ->with('success', 'Expense category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return redirect()->route('expense-categories.index')
            ->with('success', 'Expense category deleted successfully');
    }
}
