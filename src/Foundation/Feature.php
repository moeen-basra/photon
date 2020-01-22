<?php

namespace MoeenBasra\Photon\Foundation;

use MoeenBasra\Photon\Foundation\Traits\MarshalTrait;
use MoeenBasra\Photon\Foundation\Traits\JobDispatcherTrait;

abstract class Feature
{
    use MarshalTrait;
    use JobDispatcherTrait;
}
