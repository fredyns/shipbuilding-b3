<?php

namespace Snippet\Helpers;

abstract class NPWP
{
    const FORMAT = "99.999.999.9-999.999";

    public static function format($value)
    {
        if (empty($value) or !is_numeric($value)) return $value;

        $value = (string)$value;
        $len = strlen($value);

        if ($len < 15) {
            $value .= str_pad('0', (15 - $len));
        }

        $masked = substr($value, 0, 2) . '.';
        $masked .= substr($value, 2, 3) . '.';
        $masked .= substr($value, 5, 3) . '.';
        $masked .= substr($value, 8, 1) . '-';
        $masked .= substr($value, 9, 3) . '.';
        $masked .= substr($value, 12, 3);

        return $masked;
    }

    public static function native($masked)
    {
        if (empty($masked)) return null;

        return str_replace(['.', '-'], ['', ''], $masked);
    }
}
