<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'email', 'cover_image', 'status', 'user_id'];

    /**
     * Get the user that owns the store.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the medicines for the store.
     */
    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class);
    }

    /**
     * Get all the customers for the store.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get all the suppliers for the store.
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    /**
     * Get all the sales for the store.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sales::class);
    }

    /**
     * Get all the purchases for the store.
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get all the expenses for the store.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
