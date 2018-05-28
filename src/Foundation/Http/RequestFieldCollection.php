<?php
namespace Photon\Foundation\Http;

class RequestFieldCollection extends \SplObjectStorage
{
    public function attach($object, $data = null)
    {
        if (! $object instanceof RequestField) {
            throw new \InvalidArgumentException('Only valid RequestField instances are allowed');
        }
        parent::attach($object, $data);
    }
}