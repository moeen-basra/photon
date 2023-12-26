<?php

namespace MoeenBasra\Photon\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use MoeenBasra\Photon\Actions\Action;
use MoeenBasra\Photon\Events\ActionStartedEvent;
use MoeenBasra\Photon\Events\OperationStartedEvent;
use MoeenBasra\Photon\Operations\Operation;
use MoeenBasra\Photon\Tests\UnitMock;
use MoeenBasra\Photon\Tests\UnitMockRegistry;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

trait ActionRunner
{
    use Marshal;
    use DispatchesJobs;

    /**
     * decorator function to be called instead of the
     * laravel function dispatchFromArray.
     * When the $arguments is an instance of Request
     * it will call dispatchFrom instead.
     *
     * @param object|string<class-string> $action
     * @param array<string, mixed>|Request $arguments
     * @param array<string, mixed> $extra
     *
     * @return mixed
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(object|string $action, array|Request $arguments = [], array $extra = []): mixed
    {
        if (is_object($action) && !App::runningUnitTests()) {
            $result = $this->dispatchSync($action);
        } elseif ($arguments instanceof Request) {
            $result = $this->dispatchSync($this->marshal($action, $arguments, $extra));
        } else {
            if (!is_object($action)) {
                $action = $this->marshal($action, new Collection(), $arguments);

                // don't dispatch unit when in tests and have a mock for it.
            } elseif (App::runningUnitTests() && app(UnitMockRegistry::class)->has(get_class($action))) {
                /** @var UnitMock $mock */
                $mock = app(UnitMockRegistry::class)->get(get_class($action));
                $mock->compareTo($action);

                // Reaching this step confirms that the expected mock is similar to the passed instance, so we
                // get the unit's mock counterpart to be dispatched. Otherwise, the previous step would
                // throw an exception when the mock doesn't match the passed instance.
                $action = $this->marshal(
                    get_class($action),
                    new Collection(),
                    $mock->getConstructorExpectationsForInstance($action)
                );
            }

            $result = $this->dispatchSync($action);
        }

        if ($action instanceof Operation) {
            event(new OperationStartedEvent(get_class($action), $arguments));
        }

        if ($action instanceof Action) {
            event(new ActionStartedEvent(get_class($action), $arguments));
        }

        return $result;
    }

    /**
     * Run the given unit in the given queue.
     *
     * @param string<class-string> $unit
     * @param array<string, mixed> $arguments
     * @param string|null $queue
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function runInQueue(string $unit, array $arguments = [], ?string $queue = 'default'): mixed
    {
        // instantiate and queue the unit
        $reflection = new ReflectionClass($unit);
        $instance = $reflection->newInstanceArgs($arguments);
        $instance->onQueue((string)$queue);

        return $this->dispatch($instance);
    }
}
