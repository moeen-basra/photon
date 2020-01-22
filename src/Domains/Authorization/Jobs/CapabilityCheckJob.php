<?php

namespace MoeenBasra\Photon\Domains\Authorization\Jobs;

use Closure;
use MoeenBasra\Photon\Foundation\Job;
use MoeenBasra\Photon\Authorization\Exceptions\UnauthorizedAccess;

class CapabilityCheckJob extends Job
{
    protected $authorization;

    protected $closure;

    public function __construct(Closure $closure)
    {
        $this->authorization = app('authorization');
        $this->closure = $closure;
    }

    public function handle()
    {
        if ($this->authorization->capableIf($this->closure)) {
            return true;
        }

        throw new UnauthorizedAccess('You do not have enough permission to access this resource');
    }
}
