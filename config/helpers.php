<?php

use Illuminate\Support\Str;

if (! function_exists('str')) {
    /**
     * @return Str
     */
    function str(): Str
    {
        return new Str();
    }

    /**
     * @param $data
     * @return bool|false
     */
    function isJson($data): bool
    {
        if (is_array($data)) {
            return false;
        }

        return (bool) preg_match('/^({.+})|(\[{.+}])$/', $data);
    }
}
