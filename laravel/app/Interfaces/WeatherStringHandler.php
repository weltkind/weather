<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\WeatherDto;

interface WeatherStringHandler
{
    public function readFromString(string $fileContext): WeatherDto;
}
