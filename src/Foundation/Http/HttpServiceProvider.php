<?php

namespace Photon\Foundation\Http;

use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Request::class, function () {
            return Request::capture();
        });

        $this->app->alias('request', \Photon\Foundation\Http\Request::class);
    }
}
