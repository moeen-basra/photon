<?php

namespace Photon\Foundation\Events;

class FeatureStarted
{
    public function __construct(
        public string $name,
        public array $arguments = [])
    {
    }
}
