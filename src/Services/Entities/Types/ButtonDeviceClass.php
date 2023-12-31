<?php

namespace Aryxs3m\LaravelHoas\Services\Entities\Types;

/**
 * Home Assistant binary sensor device classes.
 *
 * @url https://www.home-assistant.io/integrations/binary_sensor/#device-class
 */
enum ButtonDeviceClass: string
{
    public const NONE = '';

    public const IDENTIFY = 'identify';

    public const RESTART = 'restart';

    public const UPDATE = 'update';
}
