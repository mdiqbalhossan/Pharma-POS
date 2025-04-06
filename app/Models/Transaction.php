<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'account_id',
        'type',
        'amount',
        'transaction_date',
        'description',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
