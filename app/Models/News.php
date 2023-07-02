<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "content",
        "category",
        "type",
        "image",
        "intro",
    ];

    public function categoryName(){
        if($this->category == 1)
            return "Kiến thức nhà đẹp";
        elseif($this->category == 2)
            return "Kiến thức tổng hợp";
            
    }

    public function typeName(){
        if($this->type == 1)
            return "Tin thường";
        elseif($this->type == 2)
            return "Tin nổi bật";
            
    }

}
