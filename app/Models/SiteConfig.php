<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model{
    use HasFactory;
    protected $fillable = [
        'key', 'value', 'value_en', 'order_number', 'type', 'image'
    ];
}
