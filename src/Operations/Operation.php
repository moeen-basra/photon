<?php

namespace MoeenBasra\Photon\Operations;

use MoeenBasra\Photon\Concerns\ActionRunner;
use MoeenBasra\Photon\Tests\Concerns\MockMe;

abstract class Operation
{
    use MockMe;
    use ActionRunner;
}
