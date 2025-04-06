<?php
namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::latest()->get();
        return view('account.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|in:asset,income,expense,equity,liability,other',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        // Set default value for is_active if not provided
        if (! isset($validated['is_active'])) {
            $validated['is_active'] = false;
        }

        Account::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        return view('account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|in:asset,income,expense,equity,liability,other',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        // Set default value for is_active if not provided
        if (! isset($validated['is_active'])) {
            $validated['is_active'] = false;
        }

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Account deleted successfully.');
    }
}
