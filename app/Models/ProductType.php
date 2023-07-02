<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(ProductType::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(ProductType::class, 'parent_id');
    }
}
