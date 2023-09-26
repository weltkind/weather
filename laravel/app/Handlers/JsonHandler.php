<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\WeatherDto;
use App\Interfaces\WeatherSourceHandler;
use App\Interfaces\WeatherStringHandler;
use Exception;
use Illuminate\Support\Facades\Storage;

class JsonHandler implements WeatherSourceHandler, WeatherStringHandler
{
    protected const SUPPORTED_EXTENSIONS = ['json'];

    public function read(string $path): WeatherDto
    {
        $fileContext = Storage::read($path);

        try {
            $weatherDto = $this->readFromString($fileContext);
        } catch (Exception) {
            $this->throwParseError($path);
        }

        return $weatherDto;
    }

    public function readFromString(string $fileContext): WeatherDto
    {
        $weatherArr = json_decode(
            json: $fileContext,
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        return new WeatherDto(
            airTemperatureValue: (float) $weatherArr['air_temperature']['value'],
            airTemperatureUnit: (string) $weatherArr['air_temperature']['unit'],
            airPressureValue: (float) $weatherArr['air_pressure']['value'],
            airPressureUnit: (string) $weatherArr['air_pressure']['unit'],
            windSpeedValue: (float) $weatherArr['wind_speed']['value'],
            windSpeedUnit: (string) $weatherArr['wind_speed']['unit']
        );
    }

    public function isHandle(string $ext): bool
    {
        return in_array($ext, self::SUPPORTED_EXTENSIONS);
    }


    protected function throwParseError(string $path)
    {
        throw new Exception(sprintf('Error while parse the file: %s', $path));
    }
}
