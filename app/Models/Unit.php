<?php
namespace App\Models;

use App\Trait\HasStore;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasStore;

    protected $fillable = ['name', 'description'];
}
