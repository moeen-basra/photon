<?php
namespace Photon\Foundation;

use Photon\Foundation\Traits\JobDispatcherTrait;
use Photon\Foundation\Traits\MarshalTrait;

abstract class Operation
{
    use MarshalTrait;
    use JobDispatcherTrait;
}