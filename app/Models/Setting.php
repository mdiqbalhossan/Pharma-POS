<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }

    public static function set($key, $value)
    {
        $setting = self::where('key', $key)->first();
        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            self::create(['key' => $key, 'value' => $value]);
        }
    }

}
