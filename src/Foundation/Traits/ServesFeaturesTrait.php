<?php

namespace MoeenBasra\Photon\Foundation\Traits;

use Illuminate\Support\Collection;

trait ServesFeaturesTrait
{
    use DispatchesJobsTrait;
    use MarshalTrait;

    /**
     * @param string $feature
     * @param array $arguments
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function serve(string $feature, array $arguments = [])
    {
        return $this->dispatch($this->marshal($feature, new Collection(), $arguments));
    }
}
