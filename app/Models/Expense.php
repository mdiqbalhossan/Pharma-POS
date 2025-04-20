<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['expense_category_id', 'date', 'expense_for', 'amount', 'description', 'reference', 'account_id'];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the expense category
     */
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    /**
     * Get the formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return show_amount($this->amount);
    }

    /**
     * Get the formatted date
     */
    public function getFormattedDateAttribute()
    {
        return $this->date->format('d M Y');
    }

    /**
     * Set the date attribute
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::parse($value) : null;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
