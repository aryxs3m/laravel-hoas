<?php

/**
 * Laravel - Home Assistant config
 */

return [
    'server' => env('HOAS_MQTT_SERVER', 'localhost'),
    'port' => env('HOAS_MQTT_PORT', 1883),
    'client_id' => env('HOAS_MQTT_CLIENT_ID', 'laravel_app'),
    'username' => env('HOAS_MQTT_USERNAME'),
    'password' => env('HOAS_MQTT_PASSWORD'),
];
