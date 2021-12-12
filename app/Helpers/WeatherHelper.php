<?php

namespace App\Helpers;

use App\OpenWeather\OpenWeather;

class WeatherHelper
{
    /**
     * @param array $data
     * @return array|array[]
     */
    public static function getData(array $data): array
    {
        $weather = new OpenWeather();
        $weatherData = [];

        if ($data['code']) {
            $weatherData = $weather->getCurrentWeatherByCityId($data['code']);
        } elseif($data['lat'] && $data['long']) {
            $weatherData = $weather->getCurrentWeatherByCoords($data['lat'], $data['long']);
        }

        return $weatherData;
    }
}
