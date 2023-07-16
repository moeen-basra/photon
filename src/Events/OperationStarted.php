<?php

namespace Photon\Events;

class OperationStarted
{
    public function __construct(
        readonly public string $name,
        readonly public array $arguments = [])
    {
    }
}
