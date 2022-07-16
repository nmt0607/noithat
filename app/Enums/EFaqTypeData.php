<?php


namespace App\Enums;


class EFaqTypeData {


    public static function getListData()
    {
        return [
            1 => 'Về sản phẩm',
            2 => 'Về hồ sơ nộp vay',
            3 => 'Về quy trình phê duyệt và nhận giải ngân',
            4 => 'Nhóm câu hỏi khác',
        ];
    }

    public static function valueToName($key)
    {
        $data = static::getListData();
        return $data[$key] ?? '';
    }
}