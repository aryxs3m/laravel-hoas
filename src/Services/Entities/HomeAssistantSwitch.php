<?php

namespace Aryxs3m\LaravelHoas\Services\Entities;

use Aryxs3m\LaravelHoas\Services\Entities\Traits\ActionableEntity;

/**
 * Home Assistant switch.
 *
 * With switches, you can turn on or off things in your application.
 */
class HomeAssistantSwitch extends HomeAssistantEntity
{
    use ActionableEntity;

    public function hasCommandTopic(): bool
    {
        return true;
    }

    public function getType(): string
    {
        return 'switch';
    }

    public function handleValueChange($value): void
    {
        if ($value === 'ON') {
            $this->onTurnOn();
        } else {
            $this->onTurnOff();
        }
    }

    /**
     * Called when the switch turns on from HA.
     */
    public function onTurnOn(): void
    {
    }

    /**
     * Called when the switch turned off from HA.
     */
    public function onTurnOff(): void
    {
    }

    public static function isTurnedOn(): bool
    {
        return self::get() === 'ON';
    }

    public static function turnOn(): void
    {
        static::set('ON');
    }

    public static function turnOff(): void
    {
        static::set('OFF');
    }
}
