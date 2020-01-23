<?php

namespace Photon\Domains\Authorization\Jobs;

use Closure;
use Photon\Foundation\Job;
use Photon\Authorization\Exceptions\UnauthorizedAccess;

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
