<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use Illuminate\Support\Facades\Validator;
use App\Models\News;
use App\Models\File;
use App\Helpers;
use Illuminate\Support\Str;
class NewsController extends Controller{

    public function index(Request $request){
        return view('admin.news.news-list');
    }

    public function create(Request $request){
        return view('admin.news.news-create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), News::rules(),
        $messages = [
            'name_vi.required' => 'Tiêu đề không được phép để trống.',
            'intro_vi.required' => 'Mô tả không được phép để trống.'
        ]);
        if($validator->fails()){
            return redirect('news/create')->withErrors($validator)->withInput();
        }
        $input= new News();
        // save content_vi
        if($request->content_vi){
            $content_vi = $request->content_vi;
            $content_vi = str_replace('&gt;','>',$content_vi);
            $content_vi = str_replace('&lt;','<',$content_vi);
            $dom = new \DomDocument();
            // dd($content_vi);
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($content_vi, 'HTML-ENTITIES', 'UTF-8'));    
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
                    file_put_contents($path, $data); 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', '/storage/'.$image_name);
                }
            }
            $content_vi = $dom->saveHTML();
            // xử lý bỏ html body
            if(strpos($content_vi, '<html><body>')!==false){
                $pos = strpos($content_vi, '<html><body>');
                $content_vi = substr($content_vi, $pos+12); // length <html><body>
            }
            if(stripos($content_vi, '</body></html>')!==false){
                $pos = stripos($content_vi, '</body></html>');
                $content_vi = substr($content_vi, 0,$pos);
            }
            $input->content_vi = $content_vi;  
            libxml_use_internal_errors(false);
        }
        // save content_en
        if($request->content_en){
            $content_en = $request->content_en;
            $content_en = str_replace('&gt;','>',$content_en);
            $content_en = str_replace('&lt;','<',$content_en);
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($content_en, 'HTML-ENTITIES', 'UTF-8'));    
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
                    file_put_contents($path, $data); 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', '/storage/'.$image_name);
                }
            }
            $content_en = $dom->saveHTML();
            // xử lý bỏ html body
            if(strpos($content_en, '<html><body>')!==false){
                $pos = strpos($content_en, '<html><body>');
                $content_en = substr($content_en, $pos+12); // length <html><body>
            }
            if(stripos($content_en, '</body></html>')!==false){
                $pos = stripos($content_en, '</body></html>');
                $content_en = substr($content_en, 0,$pos);
            }
            $input->content_en = $content_en;  
            libxml_use_internal_errors(false);
        }

        
        $input->name_vi= $request->name_vi;
        $input->name_en= $request->name_en;
        $input->intro_vi= $request->intro_vi;
        $input->intro_en= $request->intro_en;
        $input->meta_title_vi= $request->meta_title_vi;
        $input->meta_title_en= $request->meta_title_en;
        $input->meta_des_vi= $request->meta_des_vi;
        $input->meta_des_en= $request->meta_des_vi;
        $input->author= $request->author;
        // if($request->image){
        //     $input->image= 'storage/'.$request->image->store('public/article-file-upload');
        // }
        $input->status= $request->status;
        $input->category= $request->category;
        $input->slug= Helpers\Slug::slugify($request->name_vi);
        $input->slug_en= Helpers\Slug::slugify($request->name_en);
        $input->date_submit = $request->date_submit;
        $input->save();
        if($request->image){
            $model_name = News::class;
            $folder = app($model_name)->getTable();
            $filePath = 'storage/'.$request->image->storeAs('uploads/' . $folder . '/files/' . auth()->id(), Str::random(20).time().'.'.$request->image->extension(), 'local');

            $this->saveFile($request->image, $input->id, $filePath, $model_name, $folder);

            $input->image = $filePath;
            $input->save();
        }
        return redirect()->route('admin.news.index')->with('success', 'Tạo mới thành công');
    }

    public function saveFile($file, $model_id, $filePath, $model_name, $folder){
        $originalName = $file->getClientOriginalName();

        $fileUpload = new File();
        $fileUpload->url = $filePath;
        $fileUpload->size_file = $this->getFileSize($file);
        $fileUpload->file_name = $originalName;
        $fileUpload->model_name = $model_name;
        $fileUpload->model_id = $model_id;
        $fileUpload->note = pathinfo($originalName,PATHINFO_FILENAME);
        $fileUpload->admin_id = auth()->check() ? auth()->id() : null;

        $fileUpload->save();
    }

    public function getFileSize($file) {
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function edit(Request $request, $id){
        return view('admin.news.news-edit',compact('id'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), News::rules(),
        $messages = [
            'name_vi.required' => 'Tiêu đề không được phép để trống.',
            'intro_vi.required' => 'Mô tả không được phép để trống.'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // save content_vi
        if($request->content_vi){
            $content_vi = $request->content_vi;
            $content_vi = str_replace('&gt;','>',$content_vi);
            $content_vi = str_replace('&lt;','<',$content_vi);
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($content_vi, 'HTML-ENTITIES', 'UTF-8'));    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                // kiểm tra là ảnh mới hay ảnh cũ
                $image_old = strpos($data, 'data:image');
                if ($image_old !== false) {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $image_name= 'public/article-file-upload/' . time().mt_rand(1000000, 9999999).$k.'.png';
                    $path = storage_path() .'/app/'. $image_name;
                    file_put_contents($path, $data); 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', '/storage/'.$image_name);
                }
            }

            $content_vi = $dom->saveHTML(); 
            libxml_use_internal_errors(false);

            // xử lý bỏ html body
            if(strpos($content_vi, '<html><body>')!==false){
                $pos = strpos($content_vi, '<html><body>');
                $content_vi = substr($content_vi, $pos+12); // length <html><body>
            }
            if(stripos($content_vi, '</body></html>')!==false){
                $pos = stripos($content_vi, '</body></html>');
                $content_vi = substr($content_vi, 0,$pos);
            }
        }
        // save content_en
        if($request->content_en){
            $content_en = $request->content_en;
            $content_en = str_replace('&gt;','>',$content_en);
            $content_en = str_replace('&lt;','<',$content_en);
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml(mb_convert_encoding($content_en, 'HTML-ENTITIES', 'UTF-8'));    
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                // kiểm tra là ảnh mới hay ảnh cũ
                $image_old = strpos($data, 'data:image');
                if ($image_old !== false) {
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $image_name= 'public/article-file-upload/' . time().mt_rand(1000000, 9999999).$k.'.png';
                    $path = storage_path() .'/app/'. $image_name;
                    file_put_contents($path, $data); 
                    $img->removeAttribute('src');
                    $img->setAttribute('src', '/storage/'.$image_name);
                    dd('vào123');
                }
            }
            $content_en = $dom->saveHTML();
            libxml_use_internal_errors(false);
            // xử lý bỏ html body
            if(strpos($content_en, '<html><body>')!==false){
                $pos = strpos($content_en, '<html><body>');
                $content_en = substr($content_en, $pos+12); // length <html><body>
            }
            if(stripos($content_en, '</body></html>')!==false){
                $pos = stripos($content_en, '</body></html>');
                $content_en = substr($content_en, 0,$pos);
            }
        }
        // dd($content_en,$request->content_en,$content_en??$request->content_en);

        $data = [
            'name_vi'=> $request->name_vi,
            'name_en'=> $request->name_en,
            'intro_vi'=> $request->intro_vi,
            'intro_en'=> $request->intro_en,
            'content_vi'=> $content_vi??$request->content_vi,
            'content_en'=> $content_en??$request->content_en,
            'meta_title_vi'=> $request->meta_title_vi,
            'meta_title_en'=> $request->meta_title_en,
            'meta_des_vi'=> $request->meta_des_vi,
            'meta_des_en'=> $request->meta_des_vi,
            'status'=> $request->status,
            'author'=> $request->author,
            'slug'=> Helpers\Slug::slugify($request->name_vi),
            'slug_en'=> Helpers\Slug::slugify($request->name_en),
            'category' => $request->category,
            'date_submit' => $request->date_submit,
        ];
        $input = News::findOrFail($id);
        $input->update($data);
        if($request->image){
            if($input->image&&file_exists('./'. $input->image)){
                unlink('./'. $input->image);
                File::where('model_id',$input->id)->where('model_name',News::class)->delete();
            }
            $model_name = News::class;
            $folder = app($model_name)->getTable();
            $filePath = 'storage/'.$request->image->storeAs('uploads/' . $folder . '/files/' . auth()->id(), Str::random(20).time().'.'.$request->image->extension(), 'local');
            $this->saveFile($request->image, $input->id, $filePath, $model_name, $folder);
            $input->image = $filePath;
            $input->save();
        }
        return redirect()->route('admin.news.index')->with('success', 'Chỉnh sửa thành công');
    }
}
