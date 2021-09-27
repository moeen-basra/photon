<?php

namespace Photon\Foundation;

use Photon\Bus\MarshalTrait;
use Photon\Bus\UnitDispatcherTrait;

abstract class Feature
{
    use MarshalTrait;
    use UnitDispatcherTrait;
}
