<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    protected $fillable = [
        'sale_id',
        'medicine_id',
        'quantity',
        'unit_price',
        'total_price',
        'discount',
        'tax',
        'grand_total',
        'paid_amount',
        'due_amount',
        'payment_method',
        'note',
        'account_id',
    ];

    public function sale()
    {
        return $this->belongsTo(Sales::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
