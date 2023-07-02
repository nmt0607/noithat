<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;

class ClientController extends Controller{

    public function index(Request $request){
        return view('client.home');
    }

    public function product(Request $request){
        return view('client.product.index');
    }

    public function productDetail(Request $request, $id){
        return view('client.product.detail', ['id' => $id]);
    }

    public function news(Request $request){
        return view('client.news.index');
    }

    public function newsDetail(Request $request, $id){
        return view('client.news.detail', ['id' => $id]);
    }
}
