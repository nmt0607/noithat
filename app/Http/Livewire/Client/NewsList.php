<?php

namespace App\Http\Livewire\Client;
use App\Http\Livewire\Base\BaseLive;
use App\Models\News;

class NewsList extends BaseLive
{

    public $typeName = "Tin tức";
    public function render()
    {
        $query = News::query();
        if(isset($_GET['type_id'])){
            $this->typeName = $_GET['type_id']==1?'Kiến thức nhà đẹp':'Kiến thức tổng hợp';
            $query = $query->where('category', $_GET['type_id']);
        }
        $data = $query->get();
        return view('livewire.client.news-list', compact('data'));
    }
}
