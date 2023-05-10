<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

if (!function_exists('generateSlug')) {
    /**
     * Generate Slug Name
     *
     * @param string $slug
     * @param string $name
     * @return string
     */
    function generateSlug($slug, $name = null)
    {
        if (($slug == null || $slug == '') && ($name == null || $name == '')) return "";

        if ($slug == '') {
            return Str::slug($name, '-');
        }

        return Str::slug($slug, '-');
    }
}

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
function systemsettingsNow(string $key = ''){
    $settings = systemSettingsCollection();

    foreach(defaultSettings() as $k => $v){
        if(!$settings->has($k)){
            $settings[$k] = $v;
        }
    }

    if ($key === '') {
        return $settings;
    }

    return $settings[$key] ?? null;
}

function systemSettingsCollection(){
    return Setting::systemOnly()->get()->pluck('value', 'key');
}


function defaultSettings(){
    return [
        // Site
        'site_logo' => '',
        'logo_display_option' => 2,
        'site_title' => 'KIT Blog',
        'tagline' => 'KIT Blog tagline',
        'email' => 'contact@kit.com',
        'copyright_text' => 'Copyright &copy; 2023 - '. date('Y') .' <b><a href="http://www.zubayerahamed.com" target="_blank">Zubayer Ahamed</a></b>. All rights reserved.',

        // Social
        'social_facebook' => '',
        'social_instagram' => '',
        'social_twitter' => '',
        'social_whatsapp' => '',

    ];
}