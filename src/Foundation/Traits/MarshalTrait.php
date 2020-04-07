<?php

namespace Photon\Foundation\Traits;

use Exception;
use ArrayAccess;
use ReflectionClass;
use ReflectionParameter;

trait MarshalTrait
{
    /**
     * Marshal a command from the given array accessible object.
     *
     * @param string $command
     * @param \ArrayAccess $source
     * @param array $extras
     *
     * @return object
     */
    protected function marshal(string $command, ArrayAccess $source, array $extras = [])
    {
        $injected = [];
        $reflection = new ReflectionClass($command);
        if ($constructor = $reflection->getConstructor()) {
            $injected = array_map(function ($parameter) use ($command, $source, $extras) {
                return $this->getParameterValueForCommand($command, $source, $parameter, $extras);
            }, $constructor->getParameters());
        }

        return $reflection->newInstanceArgs($injected);
    }

    /**
     * Get a parameter value for a marshaled command.
     *
     * @param string$command
     * @param \ArrayAccess $source
     * @param \ReflectionParameter $parameter
     * @param array $extras
     *
     * @return \ArrayAccess|mixed
     * @throws \Exception
     */
    protected function getParameterValueForCommand(
        string $command,
        ArrayAccess $source,
        ReflectionParameter $parameter,
        array $extras = []
    ) {
        if (array_key_exists($parameter->name, $extras)) {
            return $extras[$parameter->name];
        }
        if (isset($source[$parameter->name])) {
            return $source[$parameter->name];
        }
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        throw new Exception(sprintf('Unable to map parameter [{%s}] to command [{%s}]', $parameter->name, $command));
    }
}
