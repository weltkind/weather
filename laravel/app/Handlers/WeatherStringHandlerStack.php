<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\WeatherDto;
use Exception;

class WeatherStringHandlerStack
{
    public function __construct(private readonly array $handlers)
    {
    }

    public function process(string $ext, string $string): WeatherDto
    {
        foreach ($this->handlers as $handler) {
            $handlerObj = app($handler);
            if ($handlerObj->isHandle($ext)) {
                return $handlerObj->readFromString($string);
            }
        }
        throw new Exception('Incorrect handlers');
    }
}
