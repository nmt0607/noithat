<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;

class AdviseController extends Controller{

    public function index(Request $request){
        return view('admin.advise.advise-list');
    }

}
