<?php

namespace Photon;

use Photon\Bus\MarshalTrait;
use Photon\Bus\UnitDispatcherTrait;

abstract class Feature
{
    use MarshalTrait;
    use UnitDispatcherTrait;
}
