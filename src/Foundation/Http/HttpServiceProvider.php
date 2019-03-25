<?php

namespace Photon\Foundation\Http;

use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (isNotLumen()) {
            $this->app->singleton(Request::class, function () {
                return Request::capture();
            });

            $this->app->alias(Request::class, 'request');
        } else {
            $this->app->singleton(Request::class, function () {
                return LumenRequest::capture();
            });

            $this->app->alias(LumenRequest::class, 'request');
        }
    }
}