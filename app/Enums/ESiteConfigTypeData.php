<?php


namespace App\Enums;


class ESiteConfigTypeData {


    public static function getListData()
    {
        return [
            1 => 'Trang chủ',
            2 => 'Trang liên hệ',
        ];
    }

    public static function valueToName($key)
    {
        $data = static::getListData();
        return $data[$key] ?? '';
    }
}