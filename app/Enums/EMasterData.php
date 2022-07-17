<?php


namespace App\Enums;


class EMasterData {
    const TOP = 0;
    const FOOTER = 1;
    const CONTENT_TO_ADVISE = 14;
    const RATE_LEVEL_RISK = 25;

    public static function getListData()
    {
        return [
            1 => 'Về chúng tôi',

            3 => 'Khách hàng nói gì về chúng tôi',
        ];
    }

    public static function valueToName($key)
    {
        $data = static::getListData();
        return $data[$key] ?? '';
    }
}
