<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'message',
        'medicine_id',
        'read',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
