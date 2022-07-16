<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class SEOConfigController extends Controller
{
    //
    public function index()
    {
        return view('admin.config.seo-config-list');
    }
}
