<?php

namespace App\Http\Livewire\Admin\Site\Files;

use App\Http\Livewire\Base\BaseLive;
use App\Models\File;
use Livewire\Component;

class FilesList extends BaseLive{
    public $searchName;
    public function render(){
        $query = File::join('users','users.id','files.admin_id')
            ->select('files.*','users.name as user_name');
        if(!empty($this->searchName)){
            $query->where(function($query){
                $query->where('model_name','LIKE','%'.$this->searchName.'%');
                $query->orWhere('file_name','LIKE','%'.$this->searchName.'%');
                $query->orWhere('users.name','LIKE','%'.$this->searchName.'%');
            });
        }
        $data = $query->orderBy('id','desc')->paginate($this->perPage);
        return view('livewire.admin.site.files.files-list',['data'=>$data]);
    }

    public function resetSearch(){
        $this->searchName = '';
    }
}
