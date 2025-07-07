<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasStore, HasFactory;

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

    protected $appends = [
        'formatted_opening_balance',
    ];

    /**
     * Get the formatted opening balance.
     *
     * @return string
     */
    public function getFormattedOpeningBalanceAttribute()
    {
        if (! $this->opening_balance) {
            return '0.00';
        }

        return number_format($this->opening_balance, 2);
    }
}
