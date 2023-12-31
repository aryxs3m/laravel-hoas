<?php

namespace Aryxs3m\LaravelHoas\Services\Entities\Types;

/**
 * Home Assistant sensor device classes.
 *
 * @url https://www.home-assistant.io/integrations/sensor/
 */
enum SensorDeviceClass: string
{
    public const APPARENT_POWER = 'APPARENT_POWER';

    public const AQI = 'AQI';

    public const ATMOSPHERIC_PRESSURE = 'ATMOSPHERIC_PRESSURE';

    public const BATTERY = 'BATTERY';

    public const CARBON_DIOXIDE = 'CARBON_DIOXIDE';

    public const CARBON_MONOXIDE = 'CARBON_MONOXIDE';

    public const CURRENT = 'CURRENT';

    public const DATA_RATE = 'DATA_RATE';

    public const DATA_SIZE = 'DATA_SIZE';

    public const DATE = 'DATE';

    public const DISTANCE = 'DISTANCE';

    public const DURATION = 'DURATION';

    public const ENERGY = 'ENERGY';

    public const ENERGY_STORAGE = 'ENERGY_STORAGE';

    public const ENUM = 'ENUM';

    public const FREQUENCY = 'FREQUENCY';

    public const GAS = 'GAS';

    public const HUMIDITY = 'HUMIDITY';

    public const ILLUMINANCE = 'ILLUMINANCE';

    public const IRRADIANCE = 'IRRADIANCE';

    public const MOISTURE = 'MOISTURE';

    public const MONETARY = 'MONETARY';

    public const NITROGEN_DIOXIDE = 'NITROGEN_DIOXIDE';

    public const NITROGEN_MONOXIDE = 'NITROGEN_MONOXIDE';

    public const NITROUS_OXIDE = 'NITROUS_OXIDE';

    public const OZONE = 'OZONE';

    public const PH = 'PH';

    public const PM1 = 'PM1';

    public const PM25 = 'PM25';

    public const PM10 = 'PM10';

    public const POWER_FACTOR = 'POWER_FACTOR';

    public const POWER = 'POWER';

    public const PRECIPITATION = 'PRECIPITATION';

    public const PRECIPITATION_INTENSITY = 'PRECIPITATION_INTENSITY';

    public const PRESSURE = 'PRESSURE';

    public const REACTIVE_POWER = 'REACTIVE_POWER';

    public const SIGNAL_STRENGTH = 'SIGNAL_STRENGTH';

    public const SOUND_PRESSURE = 'SOUND_PRESSURE';

    public const SPEED = 'SPEED';

    public const SULPHUR_DIOXIDE = 'SULPHUR_DIOXIDE';

    public const TEMPERATURE = 'TEMPERATURE';

    public const TIMESTAMP = 'TIMESTAMP';

    public const VOLATILE_ORGANIC_COMPOUNDS = 'VOLATILE_ORGANIC_COMPOUNDS';

    public const VOLATILE_ORGANIC_COMPOUNDS_PARTS = 'VOLATILE_ORGANIC_COMPOUNDS_PARTS';

    public const VOLTAGE = 'VOLTAGE';

    public const VOLUME = 'VOLUME';

    public const VOLUME_STORAGE = 'VOLUME_STORAGE';

    public const WATER = 'WATER';

    public const WEIGHT = 'WEIGHT';

    public const WIND_SPEED = 'WIND_SPEED';
}
