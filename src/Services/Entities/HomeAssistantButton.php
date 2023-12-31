<?php

namespace Aryxs3m\LaravelHoas\Services\Entities;

use Aryxs3m\LaravelHoas\Services\Entities\Traits\ActionableEntity;

/**
 * Home Assistant Button.
 *
 * Represents a simple button that can execute some action.
 */
abstract class HomeAssistantButton extends HomeAssistantEntity
{
    use ActionableEntity;

    public function hasCommandTopic(): bool
    {
        return true;
    }

    public function getType(): string
    {
        return 'button';
    }

    public function handleValueChange($value): void
    {
        $this->onPress();
    }

    /**
     * Invoked when the button is pressed in Home Assistant.
     */
    abstract public function onPress(): void;
}
