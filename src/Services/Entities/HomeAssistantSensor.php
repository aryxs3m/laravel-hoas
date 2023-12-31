<?php

namespace Aryxs3m\LaravelHoas\Services\Entities;

/**
 * Home Assistant generic sensor.
 *
 * With generic sensors you can send data to your HA instance. The value can be a string or a number.
 */
class HomeAssistantSensor extends HomeAssistantEntity
{
    protected ?string $measurementUnit = null;

    public function getType(): string
    {
        return 'sensor';
    }

    public function getMeasurementUnit(): ?string
    {
        return $this->measurementUnit;
    }

    public function setMeasurementUnit(string $measurementUnit): HomeAssistantSensor
    {
        $this->measurementUnit = $measurementUnit;

        return $this;
    }

    public function hasCommandTopic(): bool
    {
        return false;
    }
}
