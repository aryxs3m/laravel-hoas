<?php

namespace Aryxs3m\LaravelHoas\Services\Entities\Types;

/**
 * Home Assistant binary sensor device classes.
 *
 * @url https://www.home-assistant.io/integrations/binary_sensor/#device-class
 */
enum BinarySensorDeviceClass: string
{
    public const DEVICE_CLASS_BATTERY = 'battery';

    public const DEVICE_CLASS_BATTERY_CHARGING = 'battery_charging';

    public const DEVICE_CLASS_CARBON_MONOXIDE = 'carbon_monoxide';

    public const DEVICE_CLASS_COLD = 'cold';

    public const DEVICE_CLASS_CONNECTIVITY = 'connectivity';

    public const DEVICE_CLASS_DOOR = 'door';

    public const DEVICE_CLASS_GARAGE_DOOR = 'garage_door';

    public const DEVICE_CLASS_GAS = 'gas';

    public const DEVICE_CLASS_HEAT = 'heat';

    public const DEVICE_CLASS_LIGHT = 'light';

    public const DEVICE_CLASS_LOCK = 'lock';

    public const DEVICE_CLASS_MOISTURE = 'moisture';

    public const DEVICE_CLASS_MOTION = 'motion';

    public const DEVICE_CLASS_MOVING = 'moving';

    public const DEVICE_CLASS_OCCUPANCY = 'occupancy';

    public const DEVICE_CLASS_OPENING = 'opening';

    public const DEVICE_CLASS_PLUG = 'plug';

    public const DEVICE_CLASS_POWER = 'power';

    public const DEVICE_CLASS_PRESENCE = 'presence';

    public const DEVICE_CLASS_PROBLEM = 'problem';

    public const DEVICE_CLASS_RUNNING = 'running';

    public const DEVICE_CLASS_SAFETY = 'safety';

    public const DEVICE_CLASS_SMOKE = 'smoke';

    public const DEVICE_CLASS_SOUND = 'sound';

    public const DEVICE_CLASS_TAMPER = 'tamper';

    public const DEVICE_CLASS_UPDATE = 'update';

    public const DEVICE_CLASS_VIBRATION = 'vibration';

    public const DEVICE_CLASS_WINDOW = 'window';
}
