<?php

namespace MoeenBasra\Photon\Actions;


use MoeenBasra\Photon\Tests\Concerns\MockMe;

/**
 * An abstract Action to be extended by every Action.
 * Note that this Action is self-handling which
 * means it will NOT be queued, rather
 * will have the "handle()" method
 * called instead.
 */
abstract class Action
{
    use MockMe;
}