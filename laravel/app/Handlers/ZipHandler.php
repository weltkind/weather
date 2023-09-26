<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Dto\WeatherDto;
use App\Interfaces\WeatherSourceHandler;
use Exception;

class ZipHandler implements WeatherSourceHandler
{
    protected const SUPPORTED_EXTENSIONS = ['zip'];

    public function __construct(private readonly WeatherStringHandlerStack $weatherStringHandlerStack)
    {
    }

    public function read(string $path): WeatherDto
    {
        $path = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $path;

        $fileName = pathinfo($path)['filename'];

        $ext = pathinfo($fileName)['extension'];

        $unarchivedContext = file_get_contents(sprintf('zip://%s#%s', $path, $fileName));

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
