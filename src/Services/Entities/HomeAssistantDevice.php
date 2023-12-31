<?php

namespace Aryxs3m\LaravelHoas\Services\Entities;

/**
 * Home Assistant Device.
 *
 * A devices represents your application or some smaller part of it. It groups together multiple entities.
 */
class HomeAssistantDevice
{
    protected string $id;

    protected string $name;

    protected ?string $manufacturer = null;

    protected ?string $model = null;

    protected array $entities = [];

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'identifiers' => [
                $this->id,
            ],
            'manufacturer' => $this->manufacturer,
            'model' => $this->model,
            'name' => $this->name,
        ];
    }

    /**
     * @return HomeAssistantEntityInterface[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): HomeAssistantDevice
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): HomeAssistantDevice
    {
        $this->model = $model;

        return $this;
    }
}
