<?php

namespace Photon\Domains\Authorization\Jobs;

use Photon\Authorization\Exceptions\UnauthorizedAccess;
use Photon\Foundation\Job;

class CapabilityCheckJob extends Job
{
    protected $authorization;

    protected $closure;

    public function __construct(\Closure $closure)
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