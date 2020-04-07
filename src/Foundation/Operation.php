<?php

namespace Photon\Foundation;

use Photon\Foundation\Traits\MarshalTrait;
use Photon\Foundation\Traits\JobDispatcherTrait;

abstract class Operation
{
    use MarshalTrait;
    use JobDispatcherTrait;
}
