<?php

namespace App\Http\Controllers;

use App\Http\Requests\Weather\Request;
use App\Models\Cities\City;
use App\OpenWeather\OpenWeather;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    /**
     * weather index page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory
     * |\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cites = City::select('code', 'name')->orderBy('name')->limit(15)->get();
        return view('weathers.index')->with(['cites' => $cites]);
    }

    /**
     * get weather data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWeatherData(Request $request): JsonResponse
    {
        $weather = new OpenWeather();
        return response()->json(['weather' => $weather->getCurrentWeatherData($request->validated())]);
    }

    /**
     * get cites
     * @return JsonResponse
     */
    public function getCities(): JsonResponse
    {
        $cites = City::select('code', 'name')->orderBy('name')->paginate(15)->toArray();
        return response()->json(['cities' => $cites['data']]);
    }
}
