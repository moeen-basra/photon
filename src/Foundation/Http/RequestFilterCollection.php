<?php

namespace MoeenBasra\Photon\Foundation\Http;

use SplObjectStorage;
use InvalidArgumentException;

class RequestFilterCollection extends SplObjectStorage
{
    public function attach($object, $data = null)
    {
        if (!$object instanceof RequestFilter) {
            throw new InvalidArgumentException('Only valid RequestFilter instances are allowed');
        }
        parent::attach($object, $data);
    }
}
