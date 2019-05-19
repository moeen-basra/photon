<?php
if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function config_path($path = '')
    {
        return app()->make('path.config') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param string $path
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function public_path($path = '')
    {
        return app()->make('path.public') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

if (!function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array $options
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function bcrypt(string $value, $options = []): string
    {
        return app('hash')->make($value, $options);
    }
}
