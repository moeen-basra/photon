<?php
/**
 * Created by PhpStorm.
 * User: moeen-basra
 * Date: 2019-03-26
 * Time: 00:12
 */

namespace Photon\Foundation;


use Photon\Foundation\Traits\ServesFeaturesTrait;

/**
 * Class LumenController
 * @package Photon\Foundation
 */
abstract class LumenController extends \Laravel\Lumen\Routing\Controller
{
    use ServesFeaturesTrait;
}