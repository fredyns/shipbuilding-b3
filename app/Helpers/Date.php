<?php

namespace App\Helpers;

use DateTime;

class Date
{
    public static function weekDiff($from, $to)
    {
        $from = self::ensureDate($from);
        $to = self::ensureDate($to);
        if (!($from instanceof DateTime)) return null;
        if (!($to instanceof DateTime)) return null;

        $diff = $from->diff($to);

        return ceil($diff->days / 7);
    }

    public static function ensureDate($value)
    {
        if ($value instanceof DateTime) return $value;
        if (is_string($value)) return new DateTime($value);

        return null;
    }
}
