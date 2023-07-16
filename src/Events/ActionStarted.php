<?php

namespace Photon\Events;

class ActionStarted
{
    public function __construct(
        readonly public string $name,
        readonly public array $arguments = [])
    {
    }
}
