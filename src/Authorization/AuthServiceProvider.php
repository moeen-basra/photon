<?php

namespace MoeenBasra\Photon\Authorization;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('authorization', function ($app) {
            return new Authorization($app);
        });
    }
}
