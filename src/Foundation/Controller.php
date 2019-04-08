<?php

namespace Photon\Foundation;


use Photon\Foundation\Traits\ServesFeaturesTrait;

/**
 * Class Controller
 * @package Photon\Foundation
 */
class Controller extends \Laravel\Lumen\Routing\Controller
{
    use ServesFeaturesTrait;
}
