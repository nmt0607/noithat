<?php

namespace App\Http\Livewire\Admin\Site\Files;

use App\Http\Livewire\Base\BaseLive;
use App\Models\File;
use Livewire\Component;

class FilesList extends BaseLive
{
    public $searchTerm;
    public function render()
    {
        $query = File::query();
        $this->searchTerm = trim($this->searchTerm);
        if(!empty($this->searchTerm)){
            $query->where(function($query){
                $query->where('file_name','LIKE','%'.$this->searchTerm.'%');
                $query->orWhere('file_name_en','LIKE','%'.$this->searchTerm.'%');
                $query->orWhere('note','LIKE','%'.$this->searchTerm.'%');
                $query->orWhere('note_en','LIKE','%'.$this->searchTerm.'%');
            });
        }
        $data = $query->orderBy('id','desc')->paginate($this->perPage);
        return view('livewire.admin.site.files.files-list',['data'=>$data]);
    }
}
