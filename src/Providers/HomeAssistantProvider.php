<?php

namespace Aryxs3m\LaravelHoas\Providers;

use Aryxs3m\LaravelHoas\Console\Commands\MqttListener;
use Aryxs3m\LaravelHoas\Console\Commands\PublishDevices;
use Aryxs3m\LaravelHoas\Console\Commands\UpdateCalculatedEntities;
use Aryxs3m\LaravelHoas\Services\HomeAssistantService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HomeAssistantProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HomeAssistantService::class, function (Application $app) {
            return new HomeAssistantService();
        });

        $this->commands([
            MqttListener::class,
            PublishDevices::class,
            UpdateCalculatedEntities::class,
        ]);
    }

    public function provides(): array
    {
        return [
            HomeAssistantService::class,
        ];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/hoas.php' => config_path('hoas.php'),
        ]);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('hoas:listen')->everyMinute();
            $schedule->command('hoas:update-calculated-entities')->everyMinute();
        });
    }
}
