<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasStore;

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
