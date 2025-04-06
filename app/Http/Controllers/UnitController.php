<?php
namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::latest()->get();
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:units',
            'description' => 'nullable|string',
        ]);

        Unit::create($request->all());
        return redirect()->route('units.index')
            ->with('success', 'Unit created successfully.');
    }

    /**
     * Store a newly created resource in storage via AJAX.
     */
    public function ajaxStore(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:units',
            'description' => 'nullable|string',
        ]);

        $unit = Unit::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Unit created successfully',
            'data'    => $unit,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return view('units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:units,name,' . $unit->id,
            'description' => 'nullable|string',
        ]);

        $unit->update($request->all());
        return redirect()->route('units.index')
            ->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')
            ->with('success', 'Unit deleted successfully.');
    }
}
