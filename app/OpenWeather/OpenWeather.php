<?php

namespace App\OpenWeather;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

/**
 * Class MDGoogleDriveClient
 * @author Vachagan Aslanyan
 *
 * It implements the openWeather api
 *
 */
class OpenWeather
{
    private $api_key;
    private $api_endpoint_current;
    private $api_lang;

    /**
     *
     */
    public function __construct()
    {
        $this->setApiKey(Config::get('openweather.api_key'));
        $this->setApiEndpointCurrent(Config::get('openweather.api_endpoint_current'));
        $this->setApiLang(Config::get('openweather.api_lang'));
    }

    /**
     * Performs an API request and returns the response.
     * @param string $url
     * @return string
     */
    private function doRequest(string $url): string
    {
        $response = @file_get_contents($url);
        if (!$response) {
            Log::error('OpenWeather - Error fetching response from ' . $url);
            return '';
        }
        return $response;
    }

    /**
     * Calculates the textual compass direction from a bearing in degrees.
     * @param int $degrees
     * @return string
     */
    private function getDirection(int $degrees): string
    {
        $direction = '';
        $cardinal = [
            'N' => [337.5, 22.5],
            'NE' => [22.5, 67.5],
            'E' => [67.5, 112.5],
            'SE' => [112.5, 157.5],
            'S' => [157.5, 202.5],
            'SW' => [202.5, 247.5],
            'W' => [247.5, 292.5],
            'NW' => [292.5, 337.5]
        ];
        foreach ($cardinal as $dir => $angles) {
            if ($degrees >= $angles[0] && $degrees < $angles[1]) {
                $direction = $dir;
                break;
            }
        }
        return $direction;
    }

    /**
     * get cloud data
     * @param int $cloudPercent
     * @return string[]
     */
    private function getCloud(int $cloudPercent): array
    {
        $cloudData['percent'] = $cloudPercent;
        $imageFolder = Config::get('openweather.images_path');

        if ($cloudPercent >= 80 && $cloudPercent <= 100) {
            $cloudData['description'] = 'advantage thunderstorm';
            $cloudData['image'] = $imageFolder . 'strom.png';
        } elseif ($cloudPercent >= 60 && $cloudPercent < 80) {
            $cloudData['description'] = 'advantage rain';
            $cloudData['image'] = $imageFolder . 'rain.png';
        } elseif ($cloudPercent >= 40 && $cloudPercent < 60) {
            $cloudData['description'] = 'advantage cloud';
            $cloudData['image'] = $imageFolder . 'cloud.png';
        } elseif ($cloudPercent >= 20 && $cloudPercent < 40) {
            $cloudData['description'] = 'advantage partly cloud';
            $cloudData['image'] = $imageFolder . 'partly-cloudy.png';
        } else {
            $cloudData['description'] = 'advantage sun';
            $cloudData['image'] = $imageFolder . 'sun.png';
        }

        return $cloudData;
    }

    /**
     * Parses and returns an OpenWeather current weather API response as an array of formatted values.
     * @param string $response
     * @return array|array[]
     */
    private function parseCurrentResponse(string $response): array
    {
        $struct = json_decode($response, true);
        if (!isset($struct['cod']) || $struct['cod'] != 200) {
            Log::error('OpenWeather - Error parsing current response.');
            return [];
        }

        return [
            'name' => $struct['name'],
            'temp' => round($struct['main']['temp']),
            'pressure' => round($struct['main']['pressure']),//hPa
            'humidity' => round($struct['main']['humidity']),//%
            'clouds' => $this->getCloud(round($struct['clouds']['all'])),
            'wind' => [
                'speed' => $struct['wind']['speed'],//meter/sec
                'direction' => $this->getDirection($struct['wind']['deg'])
            ]
        ];
    }

    /**
     * Returns an OpenWeather API response for current weather.
     * @param array $params
     * @return array|array[]
     */
    private function getCurrentWeather(array $params): array
    {
        $params = http_build_query($params);
        $request = $this->api_endpoint_current . $params;
        $response = $this->doRequest($request);
        if (!$response) {
            return [];
        }
        $response = $this->parseCurrentResponse($response);
        if (!$response) {
            return [];
        }
        return $response;
    }

    /**
     * Returns current weather by city ID.
     * @param int $id
     * @param string $units
     * @return array[]
     */
    public function getCurrentWeatherByCityId(int $id, string $units = 'Metric'): array
    {
        return $this->getCurrentWeather([
            'id' => $id,
            'units' => $units,
            'lang' => $this->api_lang,
            'appid' => $this->api_key
        ]);
    }

    /**
     * Returns current weather by latitude and longitude.
     * @param string $latitude
     * @param string $longitude
     * @param string $units
     * @return array[]
     */
    public function getCurrentWeatherByCoords(string $latitude, string $longitude, string $units = 'Metric'): array
    {
        return $this->getCurrentWeather([
            'lat' => $latitude,
            'lon' => $longitude,
            'units' => $units,
            'lang' => $this->api_lang,
            'appid' => $this->api_key
        ]);
    }

    /**
     * Returns current weather by latitude and longitude or by code.
     * @param array $data
     * @param string $units
     * @return array|array[]
     */
    public function getCurrentWeatherData(array $data, string $units = 'Metric'): array
    {
        $weatherData = [];

        if (!empty($data['code'])) {
            $weatherData = $this->getCurrentWeatherByCityId($data['code'], $units);
        } elseif(!empty($data['lat']) && !empty($data['long'])) {
            $weatherData = $this->getCurrentWeatherByCoords($data['lat'], $data['long'], $units);
        }

        return $weatherData;
    }

    /**
     * @param mixed $api_key
     */
    public function setApiKey($api_key): void
    {
        $this->api_key = $api_key;
    }

    /**
     * @param mixed $api_endpoint_current
     */
    public function setApiEndpointCurrent($api_endpoint_current): void
    {
        $this->api_endpoint_current = $api_endpoint_current;
    }

    /**
     * @param mixed $api_lang
     */
    public function setApiLang($api_lang): void
    {
        $this->api_lang = $api_lang;
    }
}
