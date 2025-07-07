<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Medicine extends Model
{
    use HasStore;
    protected $fillable = [
        'name',
        'slug',
        'barcode',
        'generic_name',
        'medicine_type_id',
        'medicine_leaf_id',
        'unit_id',
        'supplier_id',
        'vendor_id',
        'store_id',
        'sale_price',
        'purchase_price',
        'vat_percentage',
        'discount_percentage',
        'igta', //
        'shelf',
        'hns_code', //
        'dosage',
        'quantity',
        'batch_number',
        'manufacturing_date',
        'expiration_date',
        'serial_number', //
        'lot_number',    //
        'reorder_level',
        'alert_quantity',
        'storage_condition', //
        'prescription_required',
        'side_effects',
        'contraindications',
        'loyalty_point', //
        'image',
        'description',
        'is_active',
        'sell_unit_multiple',
    ];

    /**
     * Auto generate slug when create or update
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
        self::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function medicine_type()
    {
        return $this->belongsTo(MedicineType::class);
    }

    public function medicine_leaf()
    {
        return $this->belongsTo(MedicineLeaf::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function medicine_categories()
    {
        return $this->belongsToMany(MedicineCategory::class, 'medicine_category_medicine');
    }

    public function medicine_units()
    {
        return $this->hasMany(MedicineUnit::class);
    }

    /**
     * Scope Stock IN
     */

    public function scopeStockIn($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope Is Active
     */
    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope Low Stock
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'alert_quantity');
    }

    /**
     * Scope Out Of Stock
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0);
    }

    /**
     * Scope Upcoming Expired
     */
    public function scopeUpcomingExpired($query)
    {
        return $query->whereBetween('expiration_date', [now(), now()->addDays(7)]);
    }

    /**
     * Scope Already Expired
     */
    public function scopeAlreadyExpired($query)
    {
        return $query->where('expiration_date', '<', now());
    }

    /**
     * Get the image
     */
    public function getImageAttribute()
    {
        if ($this->attributes['image']) {
            return asset('public/storage/' . $this->attributes['image']);
        }
        return asset('assets/img/placeholder.png');
    }

    /**
     * Scope Search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('generic_name', 'like', '%' . $search . '%')
            ->orWhere('barcode', 'like', '%' . $search . '%');
    }
}
