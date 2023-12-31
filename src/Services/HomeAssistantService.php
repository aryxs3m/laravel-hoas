<?php

namespace Aryxs3m\LaravelHoas\Services;

use Aryxs3m\LaravelHoas\Services\Entities\HomeAssistantDevice;
use Aryxs3m\LaravelHoas\Services\Entities\HomeAssistantEntityInterface;
use Aryxs3m\LaravelHoas\Services\Entities\HomeAssistantSensor;
use Aryxs3m\LaravelHoas\Services\Entities\HomeAssistantSwitch;
use Aryxs3m\LaravelHoas\Services\Entities\Traits\ActionableEntity;
use Illuminate\Support\Facades\Cache;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\ConfigurationInvalidException;
use PhpMqtt\Client\Exceptions\ConnectingToBrokerFailedException;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\InvalidMessageException;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\Exceptions\ProtocolViolationException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;

class HomeAssistantService
{
    const MAX_LOOP_LIFETIME = 60;

    protected static ?MqttClient $mqttClient = null;

    /**
     * @var HomeAssistantDevice[]
     */
    protected array $devices;

    /**
     * Configures devices.
     */
    public function setDevices(array $devices): void
    {
        $this->devices = $devices;
    }

    /**
     * Publish all devices to Home Assistant via MQTT.
     *
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws RepositoryException
     * @throws ProtocolNotSupportedException
     * @throws DataTransferException
     */
    public function publishDevices(): void
    {
        foreach ($this->devices as $device) {
            $this->publishDevice($device);
        }
    }

    /**
     * Publish a single device to Home Assistant.
     *
     *
     *
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws DataTransferException
     * @throws ProtocolNotSupportedException
     * @throws RepositoryException
     */
    public function publishDevice(HomeAssistantDevice $device): void
    {
        $mqtt = $this->getMqttConnection();

        foreach ($device->getEntities() as $sensor) {
            $payload = [
                'name' => $sensor->getFriendlyName(),
                'state_topic' => $this->getStateTopic($sensor),
                'unique_id' => $sensor->getId(),
                'device' => $device->toArray(),
            ];

            if ($sensor->getIcon()) {
                $payload['icon'] = $sensor->getIcon();
            }

            if ($sensor instanceof HomeAssistantSensor && $sensor->getMeasurementUnit()) {
                $payload['unit_of_measurement'] = $sensor->getMeasurementUnit();
            }

            if ($sensor->getDeviceClass()) {
                $payload['device_class'] = $sensor->getDeviceClass();
            }

            if ($sensor->hasCommandTopic()) {
                $payload['command_topic'] = $this->getCommandTopic($sensor);
            }

            $mqtt->publish($this->getConfigurationTopic($sensor),
                json_encode($payload), true);
        }

        // Publishing initial/saved values too.
        foreach ($device->getEntities() as $sensor) {
            if ($sensor->getValue() === null) {
                continue;
            }

            $this->publishEntityState($sensor);
        }
    }

    /**
     * Deletes a device from Home Assistant.
     *
     *
     *
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws DataTransferException
     * @throws ProtocolNotSupportedException
     * @throws RepositoryException
     */
    public function deleteDevice(HomeAssistantDevice $device): void
    {
        foreach ($device->getEntities() as $entity) {
            $this->deleteEntity($entity);
        }
    }

    /**
     * Delete an entity from Home Assistant.
     *
     *
     *
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws DataTransferException
     * @throws ProtocolNotSupportedException
     * @throws RepositoryException
     */
    public function deleteEntity(HomeAssistantEntityInterface $entity): void
    {
        $mqtt = $this->getMqttConnection();
        $mqtt->publish($this->getConfigurationTopic($entity), '');
    }

    /**
     * Starts the MQTT listening loop.
     * This subscribes to every entity you created and listens for changes.
     *
     * @throws ProtocolViolationException
     * @throws InvalidMessageException
     * @throws MqttClientException
     * @throws RepositoryException
     * @throws DataTransferException
     */
    public function startListenLoop($timeout = true): void
    {
        $mqtt = $this->getMqttConnection();

        $this->publishDevices();

        // Subscribing to every entity
        foreach ($this->devices as $device) {
            foreach ($device->getEntities() as $entity) {
                $mqtt->subscribe($this->getCommandTopic($entity), function (string $topic, string $message) use ($entity) {
                    echo sprintf("Received QoS level 1 message on topic [%s]: %s\n", $topic, $message);

                    $this->updateEntityValue($entity, $message);
                }, 1);
            }
        }

        // Event loop
        $x = 0;
        while ($x < self::MAX_LOOP_LIFETIME && $timeout) {
            $mqtt->loopOnce(microtime(true), true, 1000000);

            $x++;
        }
    }

    /**
     * Returns the entity value from an entity id.
     *
     * @throws \Exception
     */
    public function getEntityValue(string $entityId): mixed
    {
        $entity = $this->getEntityById($entityId);

        return Cache::get($this->getEntityStoreKey($entity));
    }

    /**
     * Sets the value for an entity by its id.
     *
     * @throws \Exception
     */
    public function setEntityValue(string $entityId, $value): void
    {
        $entity = $this->getEntityById($entityId);

        $this->updateEntityValue($entity, $value);
    }

    /**
     * Returns an entity by its id.
     *
     * @throws \Exception
     */
    protected function getEntityById(string $entityId): HomeAssistantEntityInterface
    {
        foreach ($this->devices as $device) {
            foreach ($device->getEntities() as $entity) {
                if ($entity->getId() === $entityId) {
                    return $entity;
                }
            }
        }

        throw new \Exception(sprintf('%s entity not found.', $entityId));
    }

    /**
     * Handles entity value changes from Home Assistant.
     *
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws RepositoryException
     * @throws ProtocolNotSupportedException
     * @throws DataTransferException
     */
    public function updateEntityValue(HomeAssistantEntityInterface $entity, $value): void
    {
        $entity->setValue($value);
        $this->publishEntityState($entity);

        // On actionable entities we need to call the event functions.
        if (in_array(ActionableEntity::class, class_uses_recursive($entity::class))) {
            /** @var $entity ActionableEntity */
            $entity->handleValueChange($value);
        }

        $this->updateEntityStore($entity);
    }

    /**
     * Publishes an entity's current state to HA.
     *
     *
     *
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws DataTransferException
     * @throws ProtocolNotSupportedException
     * @throws RepositoryException
     */
    protected function publishEntityState(HomeAssistantEntityInterface $entity): void
    {
        $mqtt = $this->getMqttConnection();

        $mqtt->publish($this->getStateTopic($entity),
            $entity->getValue(), true);
    }

    /**
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws DataTransferException
     * @throws ProtocolNotSupportedException
     * @throws RepositoryException
     * protected function publishSensorCommand(HomeAssistantEntityInterface $sensor): void
     * {
     * if ($sensor instanceof HomeAssistantSwitch) {
     * $mqtt = $this->getMqttConnection();
     *
     * $mqtt->publish($this->getCommandTopic($sensor),
     * $sensor->getValue(), true);
     * }
     * }
     */

    /**
     * Updates the local store for an entity.
     */
    protected function updateEntityStore(HomeAssistantEntityInterface $entity): void
    {
        Cache::put(
            $this->getEntityStoreKey($entity),
            $entity->getValue()
        );
    }

    /**
     * Returns the key to a given entity that is used in the store.
     */
    protected function getEntityStoreKey(HomeAssistantEntityInterface $entity): string
    {
        return sprintf('%s_%s_%s', 'ha', $entity->getType(), $entity->getId());
    }

    /**
     * Returns the configuration MQTT topic. This is used to publish entity metadata.
     */
    protected function getConfigurationTopic(HomeAssistantEntityInterface $entity): string
    {
        return "homeassistant/{$entity->getType()}/{$entity->getId()}/config";
    }

    /**
     * Returns the state MQTT topic. This is used to send state changes.
     */
    protected function getStateTopic(HomeAssistantEntityInterface $entity): string
    {
        return "homeassistant/{$entity->getType()}/{$entity->getId()}/state";
    }

    /**
     * Returns the command MQTT topic. This is used to send actionable entity state changes.
     */
    protected function getCommandTopic(HomeAssistantEntityInterface $entity): string
    {
        return "homeassistant/{$entity->getType()}/{$entity->getId()}/set";
    }

    /**
     * Returns the MQTT connection for Home Assistant.
     *
     * @throws ConfigurationInvalidException
     * @throws ProtocolNotSupportedException
     * @throws ConnectingToBrokerFailedException
     */
    protected function getMqttConnection(): MqttClient
    {
        if (static::$mqttClient) {
            return static::$mqttClient;
        }

        $mqtt = new MqttClient(config('hoas.server'), config('hoas.port'), config('hoas.client_id'));
        $mqtt->connect((new ConnectionSettings())
            ->setUsername(config('hoas.username'))
            ->setPassword(config('hoas.password'))
        );

        static::$mqttClient = $mqtt;

        return $mqtt;
    }
}
