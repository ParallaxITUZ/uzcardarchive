<?php

namespace App\Services;

class LangService
{
    public static function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function getLocaled($json, $lang) {
        if (self::isJson($json)){
            return (isset(json_decode($json, true)[$lang])) ? json_decode($json, true)[$lang] : json_decode($json, true)['uz'];
        } else {
            return $json;
        }
    }
}
