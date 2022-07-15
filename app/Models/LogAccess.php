<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAccess extends Model
{
    use HasFactory;

    protected $table='log_access';

    protected $fillable=[
        'ip_address',
        'url_previous',
        'device',
        'browser',
        'cookies',
        'note',
        'user_agent',
        'url_current'        
    ];
}
