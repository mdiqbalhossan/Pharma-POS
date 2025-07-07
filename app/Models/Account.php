<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasStore;

    protected $fillable = ['name', 'type', 'description', 'is_active'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getDebitAmount($startDate = null, $endDate = null)
    {
        $query = $this->transactions()->where('type', 'debit');

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        return $query->sum('amount');
    }

    public function getCreditAmount($startDate = null, $endDate = null)
    {
        $query = $this->transactions()->where('type', 'credit');

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        return $query->sum('amount');
    }

    public function getBalance($startDate = null, $endDate = null)
    {
        $debit  = $this->getDebitAmount($startDate, $endDate);
        $credit = $this->getCreditAmount($startDate, $endDate);

        return $debit - $credit;
    }
}
