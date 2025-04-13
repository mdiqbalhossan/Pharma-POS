<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'invoice_no',
        'type',
        'supplier_id',
        'date',
        'subtotal',
        'discount',
        'tax',
        'total_tax',
        'shipping',
        'grand_total',
        'paid_amount',
        'due_amount',
        'payment_method',
        'note',
        'account_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medicine_purchase')
            ->withPivot('quantity', 'unit_price', 'total_price', 'discount', 'tax', 'total_tax', 'grand_total', 'batch_no', 'expiry_date');
    }

    public function accounts()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Invoice Number
     */
    public static function getInvoiceNumber()
    {
        return 'INV-' . date('Ymd') . '-' . sprintf('%04d', (self::max('id') ?? 0) + 1);
    }
}
