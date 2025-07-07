<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineUnit extends Model
{
    protected $fillable = [
        'medicine_id',
        'unit_id',
        'sale_price',
        'purchase_price',
        'conversion_factor',
        'is_default',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
