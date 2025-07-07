<?php

namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;

class MedicineType extends Model
{
    use HasStore;

    protected $fillable = ['name', 'description'];
}
