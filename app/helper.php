<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Photo Url
 * @param string $photo
 * @return string
 */
function photo_url($photo)
{
    return asset('public/storage/' . $photo);
}

/**
 * Photo Url for PDF
 * @param string $photo
 * @return string
 */
function photo_url_pdf($photo)
{
    return public_path('storage/' . $photo);
}

/**
 * Setting
 * @param string $key
 * @return string
 */
function setting($key)
{
    return \App\Models\Setting::get($key);
}

/**
 * Currency
 * @param float $amount
 * @return string
 */
function currency($amount)
{
    return setting('currency') . ' ' . number_format($amount, 2);
}

/**
 * Currency Symbol
 * @return string
 */
function currency_symbol()
{
    return setting('currency_symbol');
}

/**
 * Show Amount
 * @param float $amount
 * @return string
 */
function show_amount($amount)
{
    return currency_symbol() . ' ' . number_format($amount, 2);
}

/**
 * Date Format
 * @param string $date
 * @return string
 */
function date_show($date)
{
    $dateFormat = setting('date_format');
    return date($dateFormat, strtotime($date));
}

/**
 * Time Format
 * @param string $time
 * @return string
 */
function time_show($time)
{
    $timeFormat = setting('time_format');
    return date($timeFormat, strtotime($time));
}

/**
 * Date Time Show
 * @param string $dateTime
 * @return string
 */
function date_time_show($dateTime)
{
    $dateFormat = setting('date_format');
    $timeFormat = setting('time_format');
    return date($dateFormat . ' ' . $timeFormat, strtotime($dateTime));
}

/**
 * Get All Languages
 * @return array
 */
function get_all_languages()
{
    $filtered = ['.', '..'];
    $dirs     = [];
    $d        = dir(resource_path('lang'));
    while (($entry = $d->read()) !== false) {
        if (is_dir(resource_path('lang') . '/' . $entry) && ! in_array($entry, $filtered)) {
            $dirs[] = $entry;
        }
    }

    return $dirs;
}

/**
 * Get Language Full name
 * @param string $language
 * @return string
 */
function get_language_full_name($language)
{
    $languages = [
        'en' => 'English',
        'bn' => 'Bengali',
        'hi' => 'Hindi',
        'ar' => 'Arabic',
        'fr' => 'French',
        'de' => 'German',
        'es' => 'Spanish',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'ko' => 'Korean',
        'pt' => 'Portuguese',
        'ru' => 'Russian',
        'tr' => 'Turkish',
        'zh' => 'Chinese',
        'nl' => 'Dutch',
        'pl' => 'Polish',
        'ro' => 'Romanian',
        'sv' => 'Swedish',
        'th' => 'Thai',
        'vi' => 'Vietnamese',
        'id' => 'Indonesian',
    ];

    return $languages[$language] ?? $language;
}

/**
 * Get Langauge Flag
 * @param string $language
 * @return string
 */
function get_language_flag($language)
{
    $languageFlags = [
        'en' => 'us',
        'bn' => 'bd',
        'hi' => 'in',
        'ar' => 'sa',
        'fr' => 'fr',
        'de' => 'de',
        'es' => 'es',
        'it' => 'it',
        'ja' => 'jp',
        'ko' => 'kr',
        'pt' => 'pt',
        'ru' => 'ru',
        'tr' => 'tr',
        'zh' => 'cn',
        'nl' => 'nl',
        'pl' => 'pl',
        'ro' => 'ro',
        'sv' => 'se',
        'th' => 'th',
        'vi' => 'vn',
        'id' => 'id',
    ];

    return $languageFlags[$language] ?? $language;
}

/**
 * Get Current User Language
 * @return string
 */
function get_current_user_language()
{
    return Session::get('locale', 'en') ?? 'en';
}

/**
 * Barcode Type
 * @param string $type
 * @return string
 */
function barcode_type($type)
{
    $barcodeTypes = [
        'CODE128' => 'C128',
        'CODE39'  => 'C39',
        'EAN13'   => 'EAN13',
        'EAN8'    => 'EAN8',
        'UPCA'    => 'UPCA',
        'UPCE'    => 'UPCE',
    ];

    return $barcodeTypes[$type] ?? $type;
}

/**
 * Low Stock Product
 * @return Collection
 */
function low_stock_product()
{
    $low_stock_quantity = setting('low_stock_alert') ?? 10;
    return \App\Models\Medicine::where('quantity', '<=', $low_stock_quantity)->get();
}

/**
 * Near Expired Product
 * @return Collection
 */
function near_expired_product()
{
    $stock_expiry_alert_days = (int) setting('stock_expiry_alert_days') ?? 30;
    return \App\Models\Medicine::where('expiration_date', '<=', now()->addDays($stock_expiry_alert_days))->get();
}

/**
 * Image Upload
 * @param Request $request
 * @param string $inputName
 * @param string $uploadPath
 * @return string|null
 */
function uploadImage(Request $request, $inputName = 'image', $uploadPath = 'uploads/images')
{
    if ($request->hasFile($inputName)) {
        $file = $request->file($inputName);

        // Create a custom name (e.g., unique ID with extension)
        $customName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Move the file to the specified folder
        $file->move(public_path('storage/' . $uploadPath), $customName);

        return $uploadPath . '/' . $customName;
    }

    return null;
}

/**
 * Purchase Info
 * @param float $unit_price
 * @param float $quantity
 * @param float $discount
 * @param float $tax
 * @return array
 */
function purchase_medicine_info($unit_price, $quantity, $discount, $tax)
{
    $subtotal        = $unit_price * $quantity;
    $discount_amount = $subtotal * $discount / 100;
    $tax_amount      = ($subtotal - $discount_amount) * $tax / 100;

    return [
        'discount' => $discount_amount,
        'tax'      => $tax_amount,
    ];
}

/**
 * App Mode
 * @return string
 */
function app_mode()
{
    return env('APP_MODE');
}

/**
 * Log Message
 * @param string $message
 */
function log_message($type, $message)
{
    if ($type == 'info') {
        Log::info($message);
    } elseif ($type == 'error') {
        Log::error($message);
    } elseif ($type == 'warning') {
        Log::warning($message);
    } elseif ($type == 'debug') {
        Log::debug($message);
    } elseif ($type == 'critical') {
        Log::critical($message);
    } elseif ($type == 'alert') {
        Log::alert($message);
    }
}
