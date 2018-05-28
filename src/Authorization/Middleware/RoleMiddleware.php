<?php

namespace Photon\Authorization\Middleware;

use Illuminate\Contracts\Foundation\Application;
use Photon\Authorization\Exceptions\UnauthorizedAccess;

class RoleMiddleware
{

    /**
     * @param Application $app
     * @param $request
     * @param \Closure $next
     * @param $role
     * @param bool $requireAll
     * @return mixed
     * @throws UnauthorizedAccess
     */
    public function handle(Application $app, $request, \Closure $next, $role, $requireAll = false)
    {
        $roles = explode('|', $role);

        if (!$app->make('authorization')->hasRole($roles, $requireAll)) {
            throw new UnauthorizedAccess();
        }
        return $next($request);
    }
}