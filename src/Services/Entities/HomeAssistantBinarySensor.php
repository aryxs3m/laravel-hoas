<?php

namespace Aryxs3m\LaravelHoas\Services\Entities;

/**
 * Home Assistant Binary Sensor
 *
 * Can represent ON or OFF state.
 */
class HomeAssistantBinarySensor extends HomeAssistantEntity
{
    public function getType(): string
    {
        return 'binary_sensor';
    }

    public function hasCommandTopic(): bool
    {
        return false;
    }

    /**
     * Returns true if the sensor state is ON.
     */
    public static function isOn(): bool
    {
        return static::get() === 'ON';
    }

    /**
     * Set the sensor state to ON.
     */
    public static function turnOn(): void
    {
        static::set('ON');
    }

    /**
     * Set the sensor state to OFF.
     */
    public static function turnOff(): void
    {
        static::set('OFF');
    }
}
