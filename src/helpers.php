<?php

if (!function_exists('is_url')) {
    /**
     * Checks whether the request url belongs to a pattern.
     *
     * @param $patterns
     * @param mixed $return
     * @param mixed $defaultReturn
     * @return mixed
     */
    function is_url($patterns, $return = true, $defaultReturn = false)
    {
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }

        foreach ($patterns as $pattern) {
            if (substr($pattern, -2) != '/*') {
                if (request()->is($pattern . '/*')) {
                    return $return;
                }
            }

            if (request()->is($pattern)) {
                return $return;
            }
        }

        return $defaultReturn;
    }
}

if (!function_exists('is_route')) {
    /**
     * Checks whether the request url belongs to a pattern.
     *
     * @param $patterns
     * @param mixed $return
     * @param mixed $defaultReturn
     * @return mixed
     */
    function is_route($patterns, $return = true, $defaultReturn = false)
    {
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }

        foreach ($patterns as $pattern) {
            if (Illuminate\Support\Facades\Route::currentRouteName() == $pattern) {
                return $return;
            }
        }

        return $defaultReturn;
    }
}
