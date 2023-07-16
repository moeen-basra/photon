<?php

namespace Photon\Events;

class FeatureStarted
{
    public function __construct(
        readonly public string $name,
        readonly public array $arguments = [])
    {
    }
}
