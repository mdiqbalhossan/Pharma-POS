<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes, HasStore;

    protected $fillable = [
        'sale_no',
        'customer_id',
        'sale_date',
        'tax_percentage',
        'discount_percentage',
        'shipping_amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'grand_total',
        'amount_paid',
        'amount_due',
        'payment_method',
        'payment_status',
        'status',
        'note',
        'user_id',
        'account_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medicine_sale')
            ->withPivot('quantity', 'price', 'total');
    }

    /**
     * Generate sale number
     */
    public static function generateSaleNumber()
    {
        $random = rand(100000, 999999);
        $sale   = self::where('sale_no', $random)->first();

        if ($sale) {
            $random = rand(100000, 999999);
            $sale   = self::where('sale_no', $random)->first();
        }

        return $random;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
