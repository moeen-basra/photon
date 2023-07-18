<?php

namespace MoeenBasra\Photon\Events;

class ActionStartedEvent
{
    /**
     * @param string $name
     * @param array<string, mixed> $arguments
     */
    public function __construct(
        readonly public string $name,
        readonly public array $arguments = [])
    {
    }
}
