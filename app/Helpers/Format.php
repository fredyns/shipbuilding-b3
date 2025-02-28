<?php

namespace App\Helpers;

class Format
{
    /**
     * @param numeric $value
     * @param string $onEmpty
     * @return string
     */
    public static function percent($value, $onEmpty = ""): string
    {
        if (!empty($value) && is_numeric($value)) {
            return number_format((float)$value, 2, ',', '.') . "%";

        }
        return $onEmpty;
    }
}
