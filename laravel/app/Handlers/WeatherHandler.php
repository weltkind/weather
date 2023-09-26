<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\WeatherDto;

class WeatherHandler
{
    public function __construct(private readonly WeatherHandlerStack $weatherHandlerStack)
    {
    }

    public function read(string $path): WeatherDto
    {
        $extension = pathinfo(storage_path() . DIRECTORY_SEPARATOR . $path)['extension'];

        return $this->weatherHandlerStack->process($extension, $path);
    }

}
