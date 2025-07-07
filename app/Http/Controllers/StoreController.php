<?php
namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::latest()->get();
        return view('store.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:stores',
            'mobile'      => 'required|string|max:20',
            'address'     => 'required|string',
            'status'      => 'required|in:active,inactive',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_name'  => 'required|string|max:255',
            'owner_email' => 'required|email|max:255|unique:users,email',
            'password'    => 'required|string|min:8',
        ]);

        try {
            DB::beginTransaction();

            // Create user (store owner)
            $user = User::create([
                'name'     => $request->owner_name,
                'email'    => $request->owner_email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('store-admin');

            // Handle cover image upload
            $coverImage = uploadImage($request, 'cover_image', 'uploads/stores');

            // Create store
            Store::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'phone'       => $request->mobile,
                'address'     => $request->address,
                'cover_image' => $coverImage,
                'status'      => $request->status,
                'user_id'     => $user->id,
            ]);

            DB::commit();

            return redirect()->route('stores.index')
                ->with('success', 'Store created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return view('store.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        return view('store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:stores,email,' . $store->id,
            'mobile'      => 'required|string|max:20',
            'address'     => 'required|string',
            'status'      => 'required|in:active,inactive',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_name'  => 'required|string|max:255',
            'owner_email' => 'required|email|max:255|unique:users,email,' . $store->user_id,
            'password'    => 'nullable|string|min:8',
        ]);

        try {
            DB::beginTransaction();

            // Update user (store owner)
            $user        = User::findOrFail($store->user_id);
            $user->name  = $request->owner_name;
            $user->email = $request->owner_email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $user->assignRole('store-admin');

            // Handle cover image update if provided
            if ($request->hasFile('cover_image')) {
                // Delete old image
                if ($store->cover_image) {
                    Storage::delete('public/' . $store->cover_image);
                }

                // Upload new image
                $coverImage = uploadImage($request, 'cover_image', 'uploads/stores');

                $store->cover_image = $coverImage;
            }

            // Update store
            $store->name    = $request->name;
            $store->email   = $request->email;
            $store->phone   = $request->mobile;
            $store->address = $request->address;
            $store->status  = $request->status;
            $store->save();

            DB::commit();

            return redirect()->route('stores.index')
                ->with('success', 'Store updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        try {
            DB::beginTransaction();

            // Delete cover image
            if ($store->cover_image) {
                Storage::delete('public/' . $store->cover_image);
            }

            // Delete store
            $store->delete();

            DB::commit();

            return redirect()->route('stores.index')
                ->with('success', 'Store deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
