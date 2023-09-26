<?php

namespace App\Console\Commands;

use App\Handlers\WeatherHandler;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class Weather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(private readonly WeatherHandler $weatherHandler)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('weather:display')
            ->setDescription('Weather');
        $this->addArgument('path', InputArgument::REQUIRED, 'Путь к файлу');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $weatherDto = $this->weatherHandler->read($this->argument('path'));

        $this->info(
            sprintf(
                'Температура воздуха: %s %s',
                $weatherDto->airTemperatureValue,
                $weatherDto->airTemperatureUnit
            )
        );

        $this->info(
            sprintf(
                'Давление воздуха: %s %s',
                $weatherDto->airPressureValue,
                $weatherDto->airPressureUnit,
            )
        );

        $this->info(
            sprintf(
                'Скорость ветра: %s %s',
                $weatherDto->windSpeedValue,
                $weatherDto->windSpeedUnit,
            )
        );
    }
}
