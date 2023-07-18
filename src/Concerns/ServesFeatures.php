<?php

namespace MoeenBasra\Photon\Concerns;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use MoeenBasra\Photon\Events\FeatureStartedEvent;

trait ServesFeatures
{
    use Marshal;
    use DispatchesJobs;

    /**
     * Serve the given feature with the given arguments.
     *
     * @param string $feature
     * @param array<string, mixed> $arguments
     *
     * @return mixed
     */
    public function serve(string $feature, array $arguments = []): mixed
    {
        event(new FeatureStartedEvent($feature, $arguments));

        return $this->dispatchSync($this->marshal($feature, new Collection(), $arguments));
    }
}
