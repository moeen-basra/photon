<?php

namespace Photon\Authorization;

use Closure;
use Illuminate\Contracts\Container\Container as Application;

class Authorization implements AuthorizeContract
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function hasRole($name, $requireAll = false): bool
    {
        if (is_array($name)) {
            return $this->checkMultipleRoles($name, $requireAll);
        } else {
            if (in_array($name, array_column($this->getRoles()->toArray(), 'role'))) {
                return true;
            }
        }
        return false;
    }

    public function getUser()
    {
        return $this->app->make('auth')->user();
    }

    public function getRoles()
    {
        return $this->getUser()->roles;
    }

    public function capableIf(Closure $closure)
    {
        if ($closure($this)) {
            return true;
        }
        return false;
    }

    protected function checkMultipleRoles(array $rolesNames, bool $requireAll)
    {
        foreach ($rolesNames as $roleName) {
            $hasRole = $this->hasRole($roleName);
            if ($hasRole && !$requireAll) {
                return true;
            } elseif (!$hasRole && $requireAll) {
                return false;
            }
        }
        return $requireAll;
    }
}
