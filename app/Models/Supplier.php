<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
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
     * Get the formatted opening balance with two decimal places.
     *
     * @return string
     */
    public function getFormattedOpeningBalanceAttribute()
    {
        return number_format((float) $this->opening_balance, 2);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
