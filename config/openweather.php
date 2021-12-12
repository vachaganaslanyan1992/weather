<?php


return [
    'api_key' => env('OPENWEATHER_API_KEY'),
    'api_endpoint_current' => 'https://api.openweathermap.org/data/2.5/weather?',
    'api_lang' => env('OPENWEATHER_API_LANG', 'en'),
    'cities_path' => database_path('seeds/resources/current.city.list.json')
];
