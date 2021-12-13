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

        if (!empty($data['code'])) {
            $weatherData = $weather->getCurrentWeatherByCityId($data['code']);
        } elseif(!empty($data['lat']) && !empty($data['long'])) {
            $weatherData = $weather->getCurrentWeatherByCoords($data['lat'], $data['long']);
        }

        return $weatherData;
    }
}
