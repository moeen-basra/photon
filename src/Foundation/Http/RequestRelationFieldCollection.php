<?php

namespace Photon\Foundation\Http;

use SplObjectStorage;
use InvalidArgumentException;

class RequestRelationFieldCollection extends SplObjectStorage
{
    public function attach($object, $data = null)
    {
        if (!$object instanceof RequestRelationField) {
            throw new InvalidArgumentException('Only valid RequestRelationField instances are allowed');
        }
        parent::attach($object, $data);
    }
}
