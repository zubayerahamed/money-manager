<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Check if the setup was completed.
 *
 * @return bool
 */
function setupCompleted()
{
    try {
        return systemsettings('system_setup_completed');
    } catch (PDOException $e) {
        Log::error($e->getMessage());
        return false;
    }
}

/**
 * Retrieve system settings with cashing forever
 *
 * @param string $key
 * @return null|Collection|string
 */
function systemsettings(string $key = '')
{
    $settings = Cache::rememberForever('systemsettings', function () {
        return Setting::systemOnly()->get()->pluck('value', 'key');
    });

    if ($key === '') {
        return $settings;
    }

    return $settings[$key] ?? null;
}

/**
 * Retrieve system settings
 *
 * @param string $key
 * @return null|Collection|string
 */
function systemsettingsNow(string $key = '')
{
    $settings = systemSettingsCollection();

    foreach (defaultSettings() as $k => $v) {
        if (!$settings->has($k)) {
            $settings[$k] = $v;
        }
    }

    if ($key === '') {
        return $settings;
    }

    return $settings[$key] ?? null;
}

function systemSettingsCollection()
{
    return Setting::systemOnly()->get()->pluck('value', 'key');
}


function defaultSettings()
{
    return [
        // Site
        'site_logo' => asset('/assets/images/money-manager-logo-light.png'),
        'site_title' => 'Money Manager',
        'copyright_text' => 'Copyright &copy; ' . date('Y') . ' &nbsp; <b><a href="http://www.zubayerahamed.com" target="_blank">Zubayer Ahamed</a></b>. All rights reserved.',
    ];
}
