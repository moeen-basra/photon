<?php

namespace Photon\Http;

use Photon\Bus\ServesFeaturesTrait;

abstract class Controller extends \Illuminate\Routing\Controller
{
    use ServesFeaturesTrait;
}