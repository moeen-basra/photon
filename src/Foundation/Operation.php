<?php

namespace MoeenBasra\Photon\Foundation;

use MoeenBasra\Photon\Foundation\Traits\MarshalTrait;
use MoeenBasra\Photon\Foundation\Traits\JobDispatcherTrait;

abstract class Operation
{
    use MarshalTrait;
    use JobDispatcherTrait;
}
