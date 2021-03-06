<?php

namespace Photon\Foundation;


use Photon\Foundation\Traits\ServesFeaturesTrait;

/**
 * Class Controller
 *
 * @package Photon\Foundation
 */
abstract class Controller extends \Illuminate\Routing\Controller
{
    use ServesFeaturesTrait;
}
