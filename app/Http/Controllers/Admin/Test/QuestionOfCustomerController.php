<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;

class QuestionOfCustomerController extends Controller{

    public function index(Request $request){
        return view('admin.question-customer.question-customer-list');
    }

}
