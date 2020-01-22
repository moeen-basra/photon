<?php

namespace MoeenBasra\Photon\Foundation;


use MoeenBasra\Photon\Foundation\Traits\ServesFeaturesTrait;

/**
 * Class Controller
 *
 * @package MoeenBasra\Photon\Foundation
 */
abstract class Controller extends \Illuminate\Routing\Controller
{
    use ServesFeaturesTrait;
}
