<?php

namespace App\Providers;

use App\Handlers\GzHandler;
use App\Handlers\JsonHandler;
use App\Handlers\WeatherHandler;
use App\Handlers\WeatherHandlerStack;
use App\Handlers\WeatherStringHandlerStack;
use App\Handlers\XmlHandler;
use App\Handlers\ZipHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherHandlerStack::class, function(){
            $handlers = [
                JsonHandler::class,
                XmlHandler::class,
                GzHandler::class,
                ZipHandler::class,

            ];
            return new WeatherHandlerStack($handlers);
        });

        $this->app->bind(WeatherStringHandlerStack::class, function(){
            $handlers = [
                JsonHandler::class,
                XmlHandler::class,
            ];
            return new WeatherStringHandlerStack($handlers);
        });

        $this->app->bind(WeatherHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
