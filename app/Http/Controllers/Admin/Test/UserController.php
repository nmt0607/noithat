<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use App\Model\User;
use SebastianBergmann\Environment\Console;

class UserController extends Controller{

    public function index(Request $request){
        return view('admin.user.user-list');
    }

}
