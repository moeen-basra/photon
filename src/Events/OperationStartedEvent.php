<?php

namespace MoeenBasra\Photon\Events;

class OperationStartedEvent
{
    public function __construct(
        readonly public string $name,
        readonly public array $arguments = [])
    {
    }
}
