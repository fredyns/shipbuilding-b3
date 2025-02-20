<?php

namespace Snippet\Helpers;

use Illuminate\Support\Arr;

class JsonField
{
    static function ensureArray($mixed)
    {
        if (empty($mixed)) {
            return [];
        }

        if (is_array($mixed)) {
            return $mixed;
        }

        return (array)json_decode($mixed, true);
    }

    static function ensureJson($mixed, $flags = JSON_UNESCAPED_UNICODE)
    {
        if (empty($mixed)) {
            return null;
        }

        if (is_string($mixed)) {
            return $mixed;
        }

        return json_encode($mixed, $flags);
    }

    protected static $cache = [];

    static function getField($obj, $field, $key = null, $default = null)
    {
        if (!is_object($obj)) return $default;

        $class = get_class($obj);
        $isCached = isset(self::$cache[$class][$field]);

        if (!$isCached) {
            self::$cache[$class][$field] = self::ensureArray($obj->{$field});
        }

        if (!$key) return self::$cache[$class][$field];

        return Arr::get(self::$cache[$class][$field], $key, $default);
    }
}
