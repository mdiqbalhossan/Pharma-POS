<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\StockAdjustment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockAdjustments = StockAdjustment::with(['medicine', 'creator'])->latest()->get();
        return view('stock_adjustment.index', compact('stockAdjustments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('stock_adjustment.create', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity'    => 'required|numeric|min:0.01',
            'type'        => 'required|in:addition,reduction',
            'reason'      => 'required|string|max:255',
            'date'        => 'required|date',
            'note'        => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Create stock adjustment
            $stockAdjustment = StockAdjustment::create([
                'medicine_id' => $request->medicine_id,
                'quantity'    => $request->quantity,
                'type'        => $request->type,
                'reason'      => $request->reason,
                'date'        => Carbon::parse($request->date)->format('Y-m-d'),
                'note'        => $request->note,
                'created_by'  => Auth::id(),
            ]);

            // Update medicine stock
            $medicine = Medicine::find($request->medicine_id);

            if ($request->type == 'addition') {
                $medicine->quantity += $request->quantity;
            } else {
                // Ensure there's enough stock to decrease
                if ($medicine->quantity < $request->quantity) {
                    throw new \Exception('Not enough stock available to decrease.');
                }
                $medicine->quantity -= $request->quantity;
            }

            $medicine->save();

            DB::commit();

            return redirect()->route('stock-adjustments.index')
                ->with('success', 'Stock adjustment created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error creating stock adjustment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StockAdjustment $stockAdjustment)
    {
        $stockAdjustment->load(['medicine', 'creator']);
        return view('stock_adjustment.show', compact('stockAdjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAdjustment $stockAdjustment)
    {
        $stockAdjustment->load(['medicine', 'creator']);
        $medicines = Medicine::all();
        return view('stock_adjustment.edit', compact('stockAdjustment', 'medicines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockAdjustment $stockAdjustment)
    {
        // Validate request
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity'    => 'required|numeric|min:0.01',
            'type'        => 'required|in:addition,reduction',
            'reason'      => 'required|string|max:255',
            'date'        => 'required|date',
            'note'        => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Revert the previous adjustment from stock
            $medicine = Medicine::find($stockAdjustment->medicine_id);
            if ($stockAdjustment->type == 'addition') {
                $medicine->quantity -= $stockAdjustment->quantity;
            } else {
                $medicine->quantity += $stockAdjustment->quantity;
            }
            $medicine->save();

            // If medicine changed, get the new medicine
            if ($medicine->id != $request->medicine_id) {
                $medicine = Medicine::find($request->medicine_id);
            }

            // Apply the new adjustment
            if ($request->type == 'addition') {
                $medicine->quantity += $request->quantity;
            } else {
                // Ensure there's enough stock to decrease
                if ($medicine->quantity < $request->quantity) {
                    throw new \Exception('Not enough stock available to decrease.');
                }
                $medicine->quantity -= $request->quantity;
            }
            $medicine->save();

            // Update the stock adjustment
            $stockAdjustment->update([
                'medicine_id' => $request->medicine_id,
                'quantity'    => $request->quantity,
                'type'        => $request->type,
                'reason'      => $request->reason,
                'date'        => Carbon::parse($request->date)->format('Y-m-d'),
                'note'        => $request->note,
            ]);

            DB::commit();

            return redirect()->route('stock-adjustments.index')
                ->with('success', 'Stock adjustment updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error updating stock adjustment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAdjustment $stockAdjustment)
    {
        try {
            DB::beginTransaction();

            // Revert the adjustment from stock
            $medicine = Medicine::find($stockAdjustment->medicine_id);
            if ($stockAdjustment->type == 'addition') {
                $medicine->quantity -= $stockAdjustment->quantity;
            } else {
                $medicine->quantity += $stockAdjustment->quantity;
            }
            $medicine->save();

            // Delete the stock adjustment
            $stockAdjustment->delete();

            DB::commit();

            return redirect()->route('stock-adjustments.index')
                ->with('success', 'Stock adjustment deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error deleting stock adjustment: ' . $e->getMessage());
        }
    }
}
