<?php

namespace Aryxs3m\LaravelHoas\Services;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for HomeAssistantService.
 *
 * @method static setDevices(array $devices)
 * @method static getEntityValue(string $sensorId)
 * @method static setEntityValue(string $sensorId, mixed $value)
 */
class HomeAssistant extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return HomeAssistantService::class;
    }
}
