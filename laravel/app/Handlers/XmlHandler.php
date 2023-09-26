<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\WeatherDto;
use App\Interfaces\WeatherSourceHandler;
use Exception;
use Illuminate\Support\Facades\Storage;

class XmlHandler implements WeatherSourceHandler
{
    protected const SUPPORTED_EXTENSIONS = ['xml'];

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
        $xml = simplexml_load_string($fileContext);

        return new WeatherDto(
            airTemperatureValue: (float) $xml->air_temperature['value'],
            airTemperatureUnit: (string) $xml->air_temperature['unit'],
            airPressureValue: (float) $xml->air_pressure['value'],
            airPressureUnit: (string) $xml->air_pressure['unit'],
            windSpeedValue: (float) $xml->wind_speed['value'],
            windSpeedUnit: (string) $xml->wind_speed['unit']
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
