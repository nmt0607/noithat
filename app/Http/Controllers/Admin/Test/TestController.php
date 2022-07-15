<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use App\Model\Test;

class TestController extends Controller{

    public function index(Request $request){
        return view('admin.test.test-list');
    }

}
