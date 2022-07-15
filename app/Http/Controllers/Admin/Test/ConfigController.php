<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;

class ConfigController extends Controller{

    public function masterData(Request $request){
        return view('admin.config.master-data-list');
    }

}
