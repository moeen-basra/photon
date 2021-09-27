<?php

namespace Photon\Foundation\Events;

class JobStarted
{
    public function __construct(
        public string $name,
        public array $arguments = [])
    {
    }
}
