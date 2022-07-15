<?php

namespace App\Http\Livewire\Admin\News;
use App\Http\Livewire\Base\BaseLive;
use App\Models\News;

class NewsEdit extends BaseLive
{
    public $editId;
    public function render(){
        $info = News::findOrFail($this->editId);
        return view('livewire.admin.news.news-edit',[
            'editId' => $this->editId,
            'info' => $info,
        ]);
    }
}
