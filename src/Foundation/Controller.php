<?php

namespace Photon\Foundation;

use Photon\Foundation\Traits\ServesFeaturesTrait;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ServesFeaturesTrait;
}
