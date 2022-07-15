<?php

namespace App\Http\Livewire\Admin\News;
use App\Http\Livewire\Base\BaseLive;
use App\Models\News;

class NewsCreate extends BaseLive
{
    public function render(){
        return view('livewire.admin.news.news-create');
    }
}
