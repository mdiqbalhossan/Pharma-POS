<?php
namespace App\Models;

use App\Models\Traits\HasStore;
use Illuminate\Database\Eloquent\Model;

class ModelExample extends Model
{
    use HasStore;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'store_id',
        // Other fields...
    ];

    /**
     * This is just an example model to show how to implement store-specific functionality
     * in your models. Follow these steps for each model that needs store-specific data:
     *
     * 1. Add "use HasStore;" to the class
     * 2. Add 'store_id' to the $fillable array
     * 3. Make sure there's a store_id column in the corresponding database table
     *
     * The HasStore trait will:
     * - Automatically add the current store_id to new records
     * - Apply a global scope to only show records for the current store
     * - Add a store() relationship method
     */

    /**
     * You can also override or extend the store scope if needed:
     */
    /*
    public function scopeWithoutStoreScope($query)
    {
        return $query->withoutGlobalScope('store');
    }
    */
}
