<?php

namespace Aryxs3m\LaravelHoas\Services\Entities;

use Aryxs3m\LaravelHoas\Services\HomeAssistant;

/**
 * Home Assistant base entity.
 */
abstract class HomeAssistantEntity implements HomeAssistantEntityInterface
{
    protected static string $id;

    protected ?string $deviceClass = null;

    protected ?string $icon = null;

    protected ?string $friendlyName = null;

    protected mixed $value = null;

    public static function make(): HomeAssistantEntityInterface
    {
        return new static();
    }

    public function getId(): string
    {
        return static::$id;
    }

    public function setId(string $id): HomeAssistantEntityInterface
    {
        static::$id = $id;

        return $this;
    }

    public function getDeviceClass(): ?string
    {
        return $this->deviceClass;
    }

    public function setDeviceClass(string $deviceClass): HomeAssistantEntityInterface
    {
        $this->deviceClass = $deviceClass;

        return $this;
    }

    /**
     * @param  mixed  $value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getFriendlyName(): ?string
    {
        return $this->friendlyName;
    }

    public function setFriendlyName(string $friendlyName): HomeAssistantEntityInterface
    {
        $this->friendlyName = $friendlyName;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): HomeAssistantEntityInterface
    {
        $this->icon = $icon;

        return $this;
    }

    public static function get(): mixed
    {
        return HomeAssistant::getEntityValue(static::$id);
    }

    public static function set($value): void
    {
        HomeAssistant::setEntityValue(static::$id, $value);
    }
}
