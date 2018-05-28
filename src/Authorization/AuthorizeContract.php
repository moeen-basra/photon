<?php

namespace Photon\Authorization;

interface AuthorizeContract
{
    public function hasRole($name, $requireAll = false): bool;

    public function getUser();

    public function getRoles();

    public function capableIf(\Closure $closure);
}