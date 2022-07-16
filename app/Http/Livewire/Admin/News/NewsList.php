<?php

namespace App\Http\Livewire\Admin\News;
use App\Http\Livewire\Base\BaseLive;
use App\Models\News;
use App\Models\File;

class NewsList extends BaseLive
{
    public $searchName;
    public $searchCategory;
    public function render()
    {
        $query = News::query();
        if($this->searchName){
            $query = $query->where(function ($query) {
                $query->where('name_vi', 'like', '%'. $this->searchName .'%')
                    ->orWhere('name_en', 'like', '%'. $this->searchName .'%')
                    ->orWhere('intro_vi', 'like', '%'. $this->searchName .'%')
                    ->orWhere('intro_en', 'like', '%'. $this->searchName .'%')
                    ->orWhere('content_vi', 'like', '%'. $this->searchName .'%')
                    ->orWhere('content_en', 'like', '%'. $this->searchName .'%')
                    ->orWhere('author','like', '%'. $this->searchName .'%');
            });
        }
        if($this->searchCategory){
            $query = $query->where('category',$this->searchCategory);
        }

        $newData = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        return view('livewire.admin.news.news-list', compact('newData'));
    }

    public function resetSearch(){
        $this->searchName = '';
        $this->searchCategory = '';
        $this->resetPage();
    }
    public function updatedSearchName(){
        $this->resetPage();
    }
    public function updatedSearchCategory(){
        $this->resetPage();
    }
    public function delete() {
        $new = News::findOrFail($this->deleteId);
        if($new->image&&file_exists('./'. $new->image)){
            unlink('./'. $new->image);
            File::where('model_id',$new->id)->where('model_name',News::class)->delete();
        }
        $new->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => "Xóa bản ghi thành công"] );
    }
}
