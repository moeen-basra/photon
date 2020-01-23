<?php

namespace Photon\Foundation;

use Photon\Foundation\Traits\MarshalTrait;
use Photon\Foundation\Traits\JobDispatcherTrait;

abstract class Feature
{
    use MarshalTrait;
    use JobDispatcherTrait;
}
