<?php

if (!function_exists('setting')) {
    /**
     * Get the specified setting value.
     *
     * @param  string $key
     *
     * @param mixed $default
     *
     * @return mixed|\Setting
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        } else {
            if (strpos($key, '::') === false) {
                $zone = 'app';
            } else {
                list($zone, $key) = explode('::', $key, 2);
            }
            $zone = app('setting')->zone($zone);

            return is_null($zone) ? $default : $zone->get($key, $default);
        }
    }
}
