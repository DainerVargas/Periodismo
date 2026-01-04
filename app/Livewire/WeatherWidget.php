<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherWidget extends Component
{
    public $temp;
    public $city;

    public function mount()
    {
        // Cache por 30 minutos
        $data = Cache::remember('weather_widget_data', 1800, function () {
            try {
                // 1. Coordenadas fijas de Fonseca, La Guajira
                $lat = 10.8858;
                $lon = -72.8481;
                $city = 'Fonseca';

                // 2. Obtener Clima
                $response = Http::timeout(2)->get("https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m");
                $weather = $response->json();

                return [
                    'temp' => isset($weather['current']['temperature_2m']) ? round($weather['current']['temperature_2m']) : '--',
                    'city' => $city
                ];

            } catch (\Exception $e) {
                return ['temp' => '--', 'city' => 'Unknown'];
            }
        });

        $this->temp = $data['temp'];
        $this->city = $data['city'];

    }

    public function render()
    {
        return view('livewire.weather-widget');
    }
}
