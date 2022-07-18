<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class SiteConfigController extends Controller
{
    //
    public function index(){
        return view('admin.config.site-config-list');
    }
}
