<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasStore;

    protected $fillable = [
        'purchase_id',
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

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
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
