<?php

namespace MoeenBasra\Photon\Events;

class ActionStartedEvent
{
    public function __construct(
        readonly public string $name,
        readonly public array $arguments = [])
    {
    }
}
