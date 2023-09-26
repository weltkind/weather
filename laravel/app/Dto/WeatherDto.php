<?php

declare(strict_types=1);

namespace App\Dto;

class WeatherDto
{
    public function __construct(
        public readonly float $airTemperatureValue,
        public readonly string $airTemperatureUnit,
        public readonly float $airPressureValue,
        public readonly string $airPressureUnit,
        public readonly float $windSpeedValue,
        public readonly string $windSpeedUnit,
    ) {
    }
}
