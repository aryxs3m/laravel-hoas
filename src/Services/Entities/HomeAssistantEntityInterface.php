<?php

namespace Aryxs3m\LaravelHoas\Services\Entities;

/**
 * All Home Assistant entities must implement this interface.
 */
interface HomeAssistantEntityInterface
{
    /**
     * Should return true, if the entity needs a command topic, e.g. switch or light.
     */
    public function hasCommandTopic(): bool;

    /**
     * Should return the entity type that will be used in the MQTT topic. E.g. binary_sensor, sensor, switch...
     */
    public function getType(): string;

    /**
     * Should return the entity's unique id.
     */
    public function getId(): string;

    /**
     * Should return the friendly name that will appear on the frontend.
     */
    public function getFriendlyName(): ?string;
}
