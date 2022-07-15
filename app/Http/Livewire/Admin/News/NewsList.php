<?php

namespace App\Http\Livewire\Admin\News;
use App\Http\Livewire\Base\BaseLive;
use App\Models\News;

class NewsList extends BaseLive
{
    public $searchName;
    public function render()
    {
        $query = News::query();
        if($this->searchName){
            $query = $query->where('name_vi', 'like', '%'. $this->searchName .'%')
            ->orWhere('name_en', 'like', '%'. $this->searchName .'%')
            ->orWhere('intro_vi', 'like', '%'. $this->searchName .'%')
            ->orWhere('intro_en', 'like', '%'. $this->searchName .'%')
            ->orWhere('content_vi', 'like', '%'. $this->searchName .'%')
            ->orWhere('content_en', 'like', '%'. $this->searchName .'%')
            ->orWhere('author','like', '%'. $this->searchName .'%');
        }

        $newData = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        return view('livewire.admin.news.news-list', compact('newData'));
    }

    public function resetSearch(){
        $this->searchName = '';
        $this->resetPage();
    }
    public function delete() {
        News::findOrFail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => "Xóa bản ghi thành công"] );
    }
}
