<?php

namespace Photon\Foundation;

use Photon\Foundation\Traits\ServesFeaturesTrait;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ServesFeaturesTrait;
}
