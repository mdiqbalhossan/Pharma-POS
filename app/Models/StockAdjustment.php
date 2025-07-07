<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use HasStore;

    protected $fillable = [
        'medicine_id',
        'quantity',
        'type',
        'reason',
        'date',
        'note',
        'created_by',
    ];

    /**
     * Get the medicine associated with the adjustment.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    /**
     * Get the user who created the adjustment.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
