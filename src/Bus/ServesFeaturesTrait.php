<?php

namespace Photon\Bus;

use Illuminate\Support\Collection;
use Photon\Foundation\Events\FeatureStarted;
use Illuminate\Foundation\Bus\DispatchesJobs;

trait ServesFeaturesTrait
{
    use DispatchesJobs;
    use MarshalTrait;


    public function serve(string $feature, array $arguments = []): mixed
    {
        event(new FeatureStarted($feature, $arguments));

        return $this->dispatch($this->marshal($feature, new Collection(), $arguments));
    }
}