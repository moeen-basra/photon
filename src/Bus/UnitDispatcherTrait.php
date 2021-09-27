<?php

namespace Photon\Bus;

use ReflectionClass;
use Photon\Foundation\Job;
use Illuminate\Http\Request;
use Photon\Foundation\Operation;
use Illuminate\Support\Collection;
use Photon\Foundation\Events\JobStarted;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Photon\Foundation\Events\OperationStarted;

trait UnitDispatcherTrait
{
    use MarshalTrait;
    use DispatchesJobs;

    /**
     * decorator function to be called instead of the
     * laravel function dispatchFromArray.
     * When the $arguments is an instance of Request
     * it will call dispatchFrom instead.
     *
     * @param mixed $job
     * @param array|\Illuminate\Http\Request $arguments
     * @param array $extra
     *
     * @return mixed
     */
    public function run(mixed $job, array|Request $arguments = [], array $extra = [])
    {
        if ($arguments instanceof Request) {
            $result = $this->dispatch($this->marshal($job, $arguments, $extra));
        } else {
            if (!is_object($job)) {
                $job = $this->marshal($job, new Collection(), $arguments);
            }

            if ($job instanceof Operation) {
                event(new OperationStarted(get_class($job), $arguments));
            }

            if ($job instanceof Job) {
                event(new JobStarted(get_class($job), $arguments));
            }

            $result = $this->dispatch($job, $arguments);
        }

        return $result;
    }

    /**
     * Run the given unit in the given queue.
     *
     * @param string $job
     * @param array $arguments
     * @param string|null $queue
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function runInQueue(string $job, array $arguments = [], ?string $queue = 'default')
    {
        // instantiate and queue the unit
        $reflection = new ReflectionClass($job);
        $instance = $reflection->newInstanceArgs($arguments);
        $instance->onQueue((string)$queue);

        return $this->dispatch($instance);
    }
}