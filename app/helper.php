<?php

/**
 * Photo Url
 */
function photo_url($photo)
{
    return asset('public/storage/' . $photo);
}

/**
 * Setting
 */
function setting($key)
{
    return \App\Models\Setting::get($key);
}

/**
 * Currency
 */
function currency($amount)
{
    return setting('currency') . ' ' . number_format($amount, 2);
}

/**
 * Currency Symbol
 */
function currency_symbol()
{
    return setting('currency_symbol');
}

/**
 * Show Amount
 */
function show_amount($amount)
{
    return currency_symbol() . ' ' . number_format($amount, 2);
}

/**
 * Date Format
 */
function date_show($date)
{
    $dateFormat = setting('date_format');
    return date($dateFormat, strtotime($date));
}

/**
 * Time Format
 */
function time_show($time)
{
    $timeFormat = setting('time_format');
    return date($timeFormat, strtotime($time));
}

/**
 * Date Time Show
 */
function date_time_show($dateTime)
{
    $dateFormat = setting('date_format');
    $timeFormat = setting('time_format');
    return date($dateFormat . ' ' . $timeFormat, strtotime($dateTime));
}
