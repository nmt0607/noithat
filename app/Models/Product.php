<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "code",
        "material",
        "status",
        "guarantee",
        "price",
        "pd_type_lv1",
        "pd_type_lv2",
        "type",
    ];



    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'pd_type_lv1');
    }

    public function avatar()
    {
        return $this->hasOne(File::class, 'model_id')->where('type',1);
    }

    public function images()
    {
        return $this->hasMany(File::class, 'model_id')->where('model_name','App\\Models\\Product');
    }
}

