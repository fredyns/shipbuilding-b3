<?php

namespace App\Lib;

class TaskType
{
    const NONE = 'none';
    const CATEGORY = 'category';
    const WORK_ITEM = 'work-item';

    public static function options()
    {
        return [
            self::NONE => 'None',
            self::CATEGORY => 'Category',
            self::WORK_ITEM => 'Work Item',
        ];
    }

    public static function values()
    {
        return array_keys(self::options());
    }
}
