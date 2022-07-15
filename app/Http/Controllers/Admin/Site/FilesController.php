<?php

namespace App\Http\Controllers\Admin\Site;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function index(){
       return view('admin.site.files.index');
    }
    public function edit($id){
        $file = File::findorfail($id);
        return view('admin.site.files.edit',['file'=>$file]);
    }
}
