<?php

namespace Photon\Bus;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Photon\Events\FeatureStarted;

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
