<?php

namespace Photon\Foundation;

use Photon\Bus\MarshalTrait;
use Photon\Bus\UnitDispatcherTrait;

abstract class Operation
{
    use MarshalTrait;
    use UnitDispatcherTrait;
}
