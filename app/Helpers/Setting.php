<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::where('key', $key)->first()?->value ?: $default;
    }
}

if (!function_exists('setting_set')) {
    function setting_set($key, $value)
    {
        Setting::updateOrCreate(compact('key'), compact('value'));
    }
}
