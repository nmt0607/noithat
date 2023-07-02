<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;

class AdminController extends Controller{

    public function index(Request $request){
        return view('admin.home');
    }

    public function product(Request $request){
        return view('admin.product.index');
    }

    public function productCreate(Request $request){
        return view('admin.product.create');
    }

    public function productEdit(Request $request, $id){
        return view('admin.product.create', compact('id'));
    }
  
    public function productType(Request $request){
        return view('admin.product-type.index');
    }

    public function masterData(Request $request){
        return view('admin.master-data.index');
    }

    public function news(Request $request){
        return view('admin.news.index');
    }

    public function newsDetail(Request $request){
        return view('admin.news.detail');
    }

    public function newsCreate()
    {
        return view('admin.news.create');
    }

    public function newsStore(Request $request)
    {
        // $validator = Validator::make($request->all(), Article::rules(),
        // $messages = [
        //     'name_vi.required' => 'Tiêu đề không được phép để trống.',
        //     'intro_vi.required' => 'Mô tả không được phép để trống.'
        // ]);
        // if($validator->fails()){
        //     return redirect('new/create')->withErrors($validator)->withInput();
        // }
        $input= new News();
        // save content_vi
        if($request->content){
            $content = $request->content;
            $content = str_replace('&gt;','>',$content);
            $content = str_replace('&lt;','<',$content);
            $dom = new \DomDocument();
            // dd($content_vi);
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                $image_old = strpos($data, 'data:image');
                if ($image_old !== false) {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $image_name= 'public/article-file-upload/' . time().mt_rand(1000000, 9999999).$k.'.png';
                    $path = storage_path() .'/app/'. $image_name;
                    // $path = str_replace('/storage','storage',$path);
                    // $path = str_replace('\storage','storage',$path);
                    file_put_contents($path, $data); 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', storage_path() .'/'. $image_name);
                }
            }
            $content = $dom->saveHTML();
            // xử lý bỏ html body
            if(strpos($content, '<html><body>')!==false){
                $pos = strpos($content, '<html><body>');
                $content = substr($content, $pos+12); // length <html><body>
            }
            if(stripos($content, '</body></html>')!==false){
                $pos = stripos($content, '</body></html>');
                $content = substr($content, 0,$pos);
            }
            $input->content = $content;  
            libxml_use_internal_errors(false);
        }

        $input->title= $request->title;
        if($request->image){
            $input->image = 'storage/'.$request->image->store('public/article-file-upload');
        }
        $input->intro= $request->intro;
        $input->type= $request->type;
        $input->category= $request->category;
        $input->save();
        return redirect()->route('admin.news.index')->with('success', 'Tạo mới thành công');
    }

    public function newsUpdate(Request $request, $id)
    {
        // dd($request->all());
        // $validator = Validator::make($request->all(), Article::rules(),
        // $messages = [
        //     'name_vi.required' => 'Tiêu đề không được phép để trống.',
        //     'intro_vi.required' => 'Mô tả không được phép để trống.'
        // ]);

        // if($validator->fails()){
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        // save content_vi
        $input = News::findOrFail($id);
        // save content_vi
        if($request->content){
            $content = $request->content;
            $content = str_replace('&gt;','>',$content);
            $content = str_replace('&lt;','<',$content);
            $dom = new \DomDocument();
            // dd($content_vi);
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                $image_old = strpos($data, 'data:image');
                if ($image_old !== false) {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $image_name= 'public/article-file-upload/' . time().mt_rand(1000000, 9999999).$k.'.png';
                    $path = storage_path() .'/app/'. $image_name;
                    // $path = str_replace('/storage','storage',$path);
                    // $path = str_replace('\storage','storage',$path);
                    file_put_contents($path, $data); 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', storage_path() .'/'. $image_name);
                }
            }
            $content = $dom->saveHTML();
            // xử lý bỏ html body
            if(strpos($content, '<html><body>')!==false){
                $pos = strpos($content, '<html><body>');
                $content = substr($content, $pos+12); // length <html><body>
            }
            if(stripos($content, '</body></html>')!==false){
                $pos = stripos($content, '</body></html>');
                $content = substr($content, 0,$pos);
            }
            $input->content = $content;  
            libxml_use_internal_errors(false);
        }

        
        if($request->image){
            $input->image = 'storage/'.$request->image->store('public/article-file-upload');
        }
        $input->intro= $request->intro;
        $input->title= $request->title;
        $input->type= $request->type;
        $input->category= $request->category;
        $input->save();
        return redirect()->route('admin.news.index')->with('success', 'Chỉnh sửa thành công');
    }

    public function newsEdit($id)
    {
        $info = News::findOrFail($id);
        
        //content_vi
        $info->content = str_replace('C:%5Cxampp%5Chtdocs%5Cbackend%5C','/',$info->content);
        $info->save();
        // $image_old = strpos($info->content_vi, 'storage/public/article-file-upload/');
        // dd($image_old);
        // if ($image_old !== false) {
        //     $info->content_vi = str_replace('https://mbcapital.com.vn/storage/public/article-file-upload/','/storage/public/article-file-upload/',$info->content_vi);
        // }  
        // //content_en
        // $image_old = strpos($info->content_en, '/storage/public/article-file-upload/');
        // if ($image_old !== false) {
        //     $info->content_en = str_replace('https://mbcapital.com.vn/storage/public/article-file-upload/','/storage/public/article-file-upload/',$info->content_en);
        // } 

        return view('admin.news.edit', compact('id', 'info'));
    }
}
