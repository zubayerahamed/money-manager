<?php

return [

    /**
     * If you want to disable the route for the log view page
     * 
     * available options: true, false
     * 
     * default: true
     */

    'is_route_enabled' => true, 
    
    
    /**
     * If you want to change the route prefix
     * 
     */
    'route_prefix' => 'kit',
    

    /**
     * If you want to change the route name
     * 
     * default: log-viewer
     */
    'route_name' => 'artisan-ui',

    /**
     * If you want to add any middleware (s) to restrict the access
     * 
     * default: web
     */
    'route_middleware' => ['web'],

    /**
     * If you want to change the page heading
     *
     */
    'page_heading' => 'Artisan UI',


    /**
     * If you want to use a authentication process access the system information view page
     */
    'authentication' => [
        'is_enabled' => env('ARTISAN_UI_AUTH_ENABLED', true),
        'login_id' => env('ARTISAN_UI_LOGIN_ID', 'zubayer'),
        'password' => env('ARTISAN_UI_LOGIN_PASSWORD', 'zubayer%123')
    ]
];