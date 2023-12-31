<?php

namespace Aryxs3m\LaravelHoas\Services\Entities\Types;

/**
 * Home Assistant binary sensor device classes.
 *
 * @url https://www.home-assistant.io/integrations/binary_sensor/#device-class
 */
enum SwitchDeviceClass: string
{
    public const NONE = '';

    public const OUTLET = 'outlet';

    public const SWITCH = 'switch';
}
