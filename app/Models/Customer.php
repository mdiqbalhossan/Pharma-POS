<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'opening_balance',
        'opening_balance_type',
    ];

    /**
     * Get the formatted opening balance.
     *
     * @return string
     */
    public function getFormattedOpeningBalanceAttribute()
    {
        $symbol = $this->opening_balance_type === 'credit' ? '+' : '-';
        return $symbol . ' ' . number_format($this->opening_balance, 2);
    }

    /**
     * Scope a query to only include customers with debit balance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDebit($query)
    {
        return $query->where('opening_balance_type', 'debit');
    }

    /**
     * Scope a query to only include customers with credit balance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCredit($query)
    {
        return $query->where('opening_balance_type', 'credit');
    }

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
}
