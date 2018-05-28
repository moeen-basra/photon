<?php
namespace Photon\Foundation\Http;

class RequestSortCollection extends \SplObjectStorage
{
    public function attach($object, $data = null)
    {
        if (! $object instanceof RequestSort) {
            throw new \InvalidArgumentException('Only valid RequestSort instances are allowed');
        }
        parent::attach($object, $data);
    }
}