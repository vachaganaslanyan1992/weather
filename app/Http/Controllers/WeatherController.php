<?php

namespace App\Http\Controllers;

use App\Helpers\WeatherHelper;
use App\Http\Requests\Weather\Request;
use App\Models\Cities\City;
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
        $cites = City::select('code', 'name')->get();
        return view('weathers.index')->with(['cites' => $cites]);
    }

    /**
     * get weather data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWeatherData(Request $request): JsonResponse
    {
        $data = WeatherHelper::getData($request->all());
        return response()->json(['weather' => $data]);
    }
}
