<?php

namespace Photon\Foundation\Traits;

use Illuminate\Support\Collection;

trait ServesFeaturesTrait
{
    use DispatchesJobsTrait;
    use MarshalTrait;

    public function serve($feature, $arguments = [])
    {
        return $this->dispatch($this->marshal($feature, new Collection(), $arguments));
    }
}