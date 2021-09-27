<?php

namespace Photon\Foundation\Events;

class OperationStarted
{
    public function __construct(
        public string $name,
        public array $arguments = [])
    {
    }
}
