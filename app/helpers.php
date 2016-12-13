<?php

if (!function_exists('routes_path')) {
    /**
     * Get the path to the routes folder.
     *
     * @param  string $path
     * @return string
     */
    function routes_path($path = '')
    {
        return app()->basePath() . DIRECTORY_SEPARATOR . 'routes' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}