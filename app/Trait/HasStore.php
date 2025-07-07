<?php
namespace App\Trait;

use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;

trait HasStore
{
    /**
     * Boot the trait.
     */
    protected static function bootHasStore()
    {
        // Add global scope to filter by store_id
        static::addGlobalScope('store', function (Builder $builder) {
            if (session()->has('store_id')) {
                $builder->where(function ($query) {
                    $query->where('store_id', session('store_id'))
                        ->orWhereNull('store_id');
                });
            }
        });

        // Auto set store_id on creating
        static::creating(function ($model) {
            if (! $model->isDirty('store_id') && session()->has('store_id')) {
                $model->store_id = session('store_id');
            }
        });
    }

    /**
     * Get the store that owns the model.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
