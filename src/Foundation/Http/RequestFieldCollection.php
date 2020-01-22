<?php

namespace MoeenBasra\Photon\Foundation\Http;

use SplObjectStorage;
use InvalidArgumentException;

class RequestFieldCollection extends SplObjectStorage
{
    public function attach($object, $data = null)
    {
        if (!$object instanceof RequestField) {
            throw new InvalidArgumentException('Only valid RequestField instances are allowed');
        }
        parent::attach($object, $data);
    }
}
