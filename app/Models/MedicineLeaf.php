<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineLeaf extends Model
{
    use HasStore, HasFactory;

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
