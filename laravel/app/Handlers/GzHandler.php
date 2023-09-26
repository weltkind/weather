<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\WeatherDto;
use App\Interfaces\WeatherSourceHandler;
use Exception;
use Illuminate\Support\Facades\Storage;

class GzHandler implements WeatherSourceHandler
{
    protected const SUPPORTED_EXTENSIONS = ['gz'];

    public function __construct(private readonly WeatherStringHandlerStack $weatherStringHandlerStack)
    {
    }

    public function read(string $path): WeatherDto
    {
        $fileContext = Storage::read($path);

        $fileName = pathinfo($path)['filename'];

        $ext = pathinfo($fileName)['extension'];

        $unarchivedContext = gzdecode($fileContext);

        return $this->weatherStringHandlerStack->process($ext, $unarchivedContext);

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
