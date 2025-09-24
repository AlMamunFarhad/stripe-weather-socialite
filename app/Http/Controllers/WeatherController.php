<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
        // /api/weather?city=Dhaka&units=metric&lang=bn
    public function byCity(Request $request)
    {
        $city  = $request->query('city', 'Dhaka');
        $units = $request->query('units', 'metric'); // metric/imperial/standard
        $lang  = $request->query('lang', 'en');

        $key  = config('services.openweather.key');
        $base = config('services.openweather.base');

        if (!$key) {
            return response()->json(['message' => 'OpenWeather key missing'], 500);
        }

        $cacheKey = "owm:weather:{$city}:{$units}:{$lang}";

        return Cache::remember($cacheKey, 60, function () use ($base, $key, $city, $units, $lang) {
            $res = Http::timeout(8)
                ->retry(2, 200)
                ->get("$base/weather", [
                    'q'     => $city,
                    'units' => $units,
                    'lang'  => $lang,
                    'appid' => $key,
                ]);

            if ($res->failed()) {
                return response()->json([
                    'message' => $res->json('message') ?? 'OpenWeather request failed',
                ], $res->status());
            }

            $data = $res->json();

            return [
                'city'        => data_get($data, 'name'),
                'country'     => data_get($data, 'sys.country'),
                'temp'        => round((float) data_get($data, 'main.temp'), 1),
                'feels_like'  => round((float) data_get($data, 'main.feels_like'), 1),
                'humidity'    => data_get($data, 'main.humidity'),
                'wind'        => data_get($data, 'wind.speed'),
                'condition'   => data_get($data, 'weather.0.main'),
                'description' => data_get($data, 'weather.0.description'),
                'icon'        => data_get($data, 'weather.0.icon'), // e.g. "10d"
                'timestamp'   => data_get($data, 'dt'),
            ];
        });
    }

    public function forecast(Request $request)
    {
        $city  = $request->query('city', 'Dhaka');
        $units = $request->query('units', 'metric');
        $lang  = $request->query('lang', 'en');

        $key  = config('services.openweather.key');
        $base = config('services.openweather.base');

        $cacheKey = "owm:forecast:{$city}:{$units}:{$lang}";

        return Cache::remember($cacheKey, 300, function () use ($base, $key, $city, $units, $lang) {
            $res = Http::timeout(8)->retry(2, 200)->get("$base/forecast", [
                'q'     => $city,
                'units' => $units,
                'lang'  => $lang,
                'appid' => $key,
            ]);

            if ($res->failed()) {
                return response()->json([
                    'message' => $res->json('message') ?? 'OpenWeather request failed',
                ], $res->status());
            }

            $list = collect($res->json('list', []))->map(function ($it) {
                return [
                    'time'        => $it['dt'],
                    'temp'        => round((float) $it['main']['temp'], 1),
                    'feels_like'  => round((float) $it['main']['feels_like'], 1),
                    'humidity'    => $it['main']['humidity'] ?? null,
                    'wind'        => $it['wind']['speed'] ?? null,
                    'description' => $it['weather'][0]['description'] ?? null,
                    'icon'        => $it['weather'][0]['icon'] ?? null,
                ];
            })->all();

            return [
                'city'  => data_get($res->json(), 'city.name'),
                'list'  => $list,
            ];
        });
    }
}
