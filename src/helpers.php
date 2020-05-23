<?php

if (!function_exists('is_url')) {
    /**
     * Checks whether the request url belongs to a pattern.
     *
     * @param $patterns
     * @param \Illuminate\Http\Request|null $request
     * @return mixed
     */
    function is_url($patterns, $request = null)
    {
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }
        if (is_null($request)) {
            $request = request();
        }

        foreach ($patterns as $pattern) {
            if (substr($pattern, -2) != '/*') {
                if ($request->is($pattern . '/*')) {
                    return true;
                }
            }

            if ($request->is($pattern)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('is_route')) {
    /**
     * Checks whether the request url belongs to a pattern.
     *
     * @param $patterns
     * @param \Illuminate\Http\Request|null $request
     * @return bool
     */
    function is_route($patterns, $request = null)
    {
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }
        if (is_null($request)) {
            $request = request();
        }

        foreach ($patterns as $pattern) {
            if ($request->route()->named($pattern)) {
                return true;
            }
        }

        return false;
    }
}
