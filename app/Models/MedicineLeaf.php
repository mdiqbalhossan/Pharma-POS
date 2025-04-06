<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineLeaf extends Model
{
    use HasFactory;

    protected $table = 'medicine_leafs';

    protected $fillable = ['type', 'qty_box'];

    /**
     * Get the formatted type name
     */
    public function getFormattedTypeAttribute()
    {
        return ucfirst($this->type);
    }
}
