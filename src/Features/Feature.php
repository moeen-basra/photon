<?php

namespace MoeenBasra\Photon\Features;

use MoeenBasra\Photon\Concerns\ActionRunner;
use MoeenBasra\Photon\Tests\MockMe;

abstract class Feature
{
    use MockMe;
    use ActionRunner;
}
