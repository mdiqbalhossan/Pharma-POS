<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MedicineCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $appends = [
        'medicine_count',
        'image',
    ];

    /**
     * Auto generate slug when create or update
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
        self::updating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    /**
     * Get the medicines
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medicine_category_medicine');
    }

    /**
     * Get the medicine count
     */
    public function getMedicineCountAttribute()
    {
        return $this->medicines()->count();
    }

    /**
     * Get the image
     */
    public function getImageAttribute()
    {
        // Get the initials from the name
        $nameParts = explode(' ', $this->name);
        $initials  = '';

        if (count($nameParts) >= 2) {
            // Use first letter of first and last name
            $initials = mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[count($nameParts) - 1], 0, 1);
        } else {
            // If only one name, use the first two letters or just the first letter
            $initials = mb_substr($this->name, 0, min(2, mb_strlen($this->name)));
        }

        $initials = strtoupper($initials);

        // Generate a color based on the name
        $hash       = md5($this->name);
        $hue        = hexdec(substr($hash, 0, 2)) % 360;
        $saturation = 65;
        $lightness  = 60;

        $bgColor = "hsl($hue, {$saturation}%, {$lightness}%)";

        // Create the SVG
        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
            <rect width="40" height="40" fill="$bgColor" />
            <text x="20" y="25" font-family="Arial, Helvetica, sans-serif" font-size="16" font-weight="bold" fill="white" text-anchor="middle">$initials</text>
        </svg>
        SVG;

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

}
