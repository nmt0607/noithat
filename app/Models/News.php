<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_vi',
        'name_en',
        'intro_vi',
        'intro_en',
        'content_vi',
        'content_en',
        'meta_title_vi',
        'meta_title_en',
        'meta_des_vi',
        'meta_des_en',
        'image',
        'status',
        'type', // 1: Không trong danh mục, 2: có trong danh mục
        'category',
        'date_submit',
        'author'
    ];

    protected $status = ["Chưa kích hoạt", "Đang hoạt động"];

    public static function rules() {
        return [
            'name_vi' => 'required|max:255',
            'intro_vi' => 'required',
            'image' => 'mimes:jpeg,jpg,png'
        ];
    }
}
