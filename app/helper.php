<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Check if the setup was completed.
 *
 * @return bool
 */
if (!function_exists('setupCompleted')) {
    function setupCompleted()
    {
        try {
            return systemsettings('system_setup_completed');
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}


/**
 * Retrieve system settings with cashing forever
 *
 * @param string $key
 * @return null|Collection|string
 */
if (!function_exists('systemsettings')) {
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
}


/**
 * Retrieve system settings
 *
 * @param string $key
 * @return null|Collection|string
 */
if (!function_exists('systemsettingsNow')) {
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
}


if (!function_exists('systemSettingsCollection')) {
    function systemSettingsCollection()
    {
        return Setting::systemOnly()->get()->pluck('value', 'key');
    }
}


if (!function_exists('defaultSettings')) {
    function defaultSettings()
    {
        return [
            // Site
            'site_logo' => asset('/assets/images/money-manager-logo-light.png'),
            'site_title' => 'Money Manager',
            'copyright_text' => 'Copyright &copy; ' . date('Y') . ' &nbsp; <b><a href="http://www.zubayerahamed.com" target="_blank">Zubayer Ahamed</a></b>. All rights reserved.',
        ];
    }
}



/**
 * Push new data to an array
 *
 * @param array $array
 * @param string $key
 * @param mixed $value
 * @return array
 */
if (!function_exists('array_push_assoc')) {
    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }
}


if (!function_exists('getAllCurrency')) {
    function getAllCurrency()
    {
        return [
            "AFN" => "AFN - Afghan Afghani",
            "ALL" => "ALL - Albanian Lek",
            "DZD" => "DZD - Algerian Dinar",
            "AOA" => "AOA - Angolan Kwanza",
            "ARS" => "ARS - Argentine Peso",
            "AMD" => "AMD - Armenian Dram",
            "AWG" => "AWG - Aruban Florin",
            "AUD" => "AUD - Australian Dollar",
            "AZN" => "AZN - Azerbaijani Manat",
            "BSD" => "BSD - Bahamian Dollar",
            "BHD" => "BHD - Bahraini Dinar",
            "BDT" => "BDT - Bangladeshi Taka",
            "BBD" => "BBD - Barbadian Dollar",
            "BYR" => "BYR - Belarusian Ruble",
            "BEF" => "BEF - Belgian Franc",
            "BZD" => "BZD - Belize Dollar",
            "BMD" => "BMD - Bermudan Dollar",
            "BTN" => "BTN - Bhutanese Ngultrum",
            "BTC" => "BTC - Bitcoin",
            "BOB" => "BOB - Bolivian Boliviano",
            "BAM" => "BAM - Bosnia-Herzegovina Convertible Mark",
            "BWP" => "BWP - Botswanan Pula",
            "BRL" => "BRL - Brazilian Real",
            "GBP" => "GBP - British Pound Sterling",
            "BND" => "BND - Brunei Dollar",
            "BGN" => "BGN - Bulgarian Lev",
            "BIF" => "BIF - Burundian Franc",
            "KHR" => "KHR - Cambodian Riel",
            "CAD" => "CAD - Canadian Dollar",
            "CVE" => "CVE - Cape Verdean Escudo",
            "KYD" => "KYD - Cayman Islands Dollar",
            "XOF" => "XOF - CFA Franc BCEAO",
            "XAF" => "XAF - CFA Franc BEAC",
            "XPF" => "XPF - CFP Franc",
            "CLP" => "CLP - Chilean Peso",
            "CNY" => "CNY - Chinese Yuan",
            "COP" => "COP - Colombian Peso",
            "KMF" => "KMF - Comorian Franc",
            "CDF" => "CDF - Congolese Franc",
            "CRC" => "CRC - Costa Rican ColÃ³n",
            "HRK" => "HRK - Croatian Kuna",
            "CUC" => "CUC - Cuban Convertible Peso",
            "CZK" => "CZK - Czech Republic Koruna",
            "DKK" => "DKK - Danish Krone",
            "DJF" => "DJF - Djiboutian Franc",
            "DOP" => "DOP - Dominican Peso",
            "XCD" => "XCD - East Caribbean Dollar",
            "EGP" => "EGP - Egyptian Pound",
            "ERN" => "ERN - Eritrean Nakfa",
            "EEK" => "EEK - Estonian Kroon",
            "ETB" => "ETB - Ethiopian Birr",
            "EUR" => "EUR - Euro",
            "FKP" => "FKP - Falkland Islands Pound",
            "FJD" => "FJD - Fijian Dollar",
            "GMD" => "GMD - Gambian Dalasi",
            "GEL" => "GEL - Georgian Lari",
            "DEM" => "DEM - German Mark",
            "GHS" => "GHS - Ghanaian Cedi",
            "GIP" => "GIP - Gibraltar Pound",
            "GRD" => "GRD - Greek Drachma",
            "GTQ" => "GTQ - Guatemalan Quetzal",
            "GNF" => "GNF - Guinean Franc",
            "GYD" => "GYD - Guyanaese Dollar",
            "HTG" => "HTG - Haitian Gourde",
            "HNL" => "HNL - Honduran Lempira",
            "HKD" => "HKD - Hong Kong Dollar",
            "HUF" => "HUF - Hungarian Forint",
            "ISK" => "ISK - Icelandic KrÃ³na",
            "INR" => "INR - Indian Rupee",
            "IDR" => "IDR - Indonesian Rupiah",
            "IRR" => "IRR - Iranian Rial",
            "IQD" => "IQD - Iraqi Dinar",
            "ILS" => "ILS - Israeli New Sheqel",
            "ITL" => "ITL - Italian Lira",
            "JMD" => "JMD - Jamaican Dollar",
            "JPY" => "JPY - Japanese Yen",
            "JOD" => "JOD - Jordanian Dinar",
            "KZT" => "KZT - Kazakhstani Tenge",
            "KES" => "KES - Kenyan Shilling",
            "KWD" => "KWD - Kuwaiti Dinar",
            "KGS" => "KGS - Kyrgystani Som",
            "LAK" => "LAK - Laotian Kip",
            "LVL" => "LVL - Latvian Lats",
            "LBP" => "LBP - Lebanese Pound",
            "LSL" => "LSL - Lesotho Loti",
            "LRD" => "LRD - Liberian Dollar",
            "LYD" => "LYD - Libyan Dinar",
            "LTL" => "LTL - Lithuanian Litas",
            "MOP" => "MOP - Macanese Pataca",
            "MKD" => "MKD - Macedonian Denar",
            "MGA" => "MGA - Malagasy Ariary",
            "MWK" => "MWK - Malawian Kwacha",
            "MYR" => "MYR - Malaysian Ringgit",
            "MVR" => "MVR - Maldivian Rufiyaa",
            "MRO" => "MRO - Mauritanian Ouguiya",
            "MUR" => "MUR - Mauritian Rupee",
            "MXN" => "MXN - Mexican Peso",
            "MDL" => "MDL - Moldovan Leu",
            "MNT" => "MNT - Mongolian Tugrik",
            "MAD" => "MAD - Moroccan Dirham",
            "MZM" => "MZM - Mozambican Metical",
            "MMK" => "MMK - Myanmar Kyat",
            "NAD" => "NAD - Namibian Dollar",
            "NPR" => "NPR - Nepalese Rupee",
            "ANG" => "ANG - Netherlands Antillean Guilder",
            "TWD" => "TWD - New Taiwan Dollar",
            "NZD" => "NZD - New Zealand Dollar",
            "NIO" => "NIO - Nicaraguan CÃ³rdoba",
            "NGN" => "NGN - Nigerian Naira",
            "KPW" => "KPW - North Korean Won",
            "NOK" => "NOK - Norwegian Krone",
            "OMR" => "OMR - Omani Rial",
            "PKR" => "PKR - Pakistani Rupee",
            "PAB" => "PAB - Panamanian Balboa",
            "PGK" => "PGK - Papua New Guinean Kina",
            "PYG" => "PYG - Paraguayan Guarani",
            "PEN" => "PEN - Peruvian Nuevo Sol",
            "PHP" => "PHP - Philippine Peso",
            "PLN" => "PLN - Polish Zloty",
            "QAR" => "QAR - Qatari Rial",
            "RON" => "RON - Romanian Leu",
            "RUB" => "RUB - Russian Ruble",
            "RWF" => "RWF - Rwandan Franc",
            "SVC" => "SVC - Salvadoran ColÃ³n",
            "WST" => "WST - Samoan Tala",
            "SAR" => "SAR - Saudi Riyal",
            "RSD" => "RSD - Serbian Dinar",
            "SCR" => "SCR - Seychellois Rupee",
            "SLL" => "SLL - Sierra Leonean Leone",
            "SGD" => "SGD - Singapore Dollar",
            "SKK" => "SKK - Slovak Koruna",
            "SBD" => "SBD - Solomon Islands Dollar",
            "SOS" => "SOS - Somali Shilling",
            "ZAR" => "ZAR - South African Rand",
            "KRW" => "KRW - South Korean Won",
            "XDR" => "XDR - Special Drawing Rights",
            "LKR" => "LKR - Sri Lankan Rupee",
            "SHP" => "SHP - St. Helena Pound",
            "SDG" => "SDG - Sudanese Pound",
            "SRD" => "SRD - Surinamese Dollar",
            "SZL" => "SZL - Swazi Lilangeni",
            "SEK" => "SEK - Swedish Krona",
            "CHF" => "CHF - Swiss Franc",
            "SYP" => "SYP - Syrian Pound",
            "STD" => "STD - São Tomé and Príncipe Dobra",
            "TJS" => "TJS - Tajikistani Somoni",
            "TZS" => "TZS - Tanzanian Shilling",
            "THB" => "THB - Thai Baht",
            "TOP" => "TOP - Tongan pa'anga",
            "TTD" => "TTD - Trinidad & Tobago Dollar",
            "TND" => "TND - Tunisian Dinar",
            "TRY" => "TRY - Turkish Lira",
            "TMT" => "TMT - Turkmenistani Manat",
            "UGX" => "UGX - Ugandan Shilling",
            "UAH" => "UAH - Ukrainian Hryvnia",
            "AED" => "AED - United Arab Emirates Dirham",
            "UYU" => "UYU - Uruguayan Peso",
            "USD" => "USD - US Dollar",
            "UZS" => "UZS - Uzbekistan Som",
            "VUV" => "VUV - Vanuatu Vatu",
            "VEF" => "VEF - Venezuelan BolÃ­var",
            "VND" => "VND - Vietnamese Dong",
            "YER" => "YER - Yemeni Rial",
            "ZMK" => "ZMK - Zambian Kwacha"
        ];
    }
}
