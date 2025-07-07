<?php
namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreSelectionController extends Controller
{
    /**
     * Display the store selection page.
     */
    public function select()
    {
        $stores = Store::where('status', 'active')->latest()->get();
        return view('store-selection.select', compact('stores'));
    }

    /**
     * Set the selected store in session.
     */
    public function set(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
        ]);

        // Store the selected store ID in session
        session(['store_id' => $request->store_id]);

        // Get store details for flash message
        $store = Store::findOrFail($request->store_id);
        $previous_url = session('previous_url');
        return redirect()->to($previous_url)
            ->with('success', 'You are now working with ' . $store->name);
    }

    /**
     * Change the current store.
     */
    public function change()
    {
        // Clear the store from session
        session()->forget('store_id');
        $previous_url = url()->previous();
        session(['previous_url' => $previous_url]);
        return redirect()->route('store.select')
            ->with('info', 'Please select a store to work with.');
    }
}
