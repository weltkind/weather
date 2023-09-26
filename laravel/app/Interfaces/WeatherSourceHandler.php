<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\WeatherDto;

interface WeatherSourceHandler
{
    public function read(string $path): WeatherDto;

    public function isHandle(string $ext): bool;
}
