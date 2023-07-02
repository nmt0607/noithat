<?php

namespace App\Http\Livewire\Admin;
use App\Http\Livewire\Base\BaseLive;
use App\Models\News;
use App\Models\File;
use Storage;
class NewsList extends BaseLive
{
    public $searchName;
    public $searchCategory;
    public function render()
    {
        $query = News::query();
        if($this->searchName){
            $query = $query->where(function ($query) {
                $query->where('title', 'like', '%'. $this->searchName .'%');
            });
        }
        if($this->searchCategory){
            $query = $query->where('category',$this->searchCategory);
        }

        $newData = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        return view('livewire.admin.news-list', compact('newData'));
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
        if($new->image&&Storage::disk('s3')->exists($new->image)){
            Storage::disk('s3')->delete($new->image);
            File::where('model_id',$new->id)->where('model_name',News::class)->delete();
        }
        $new->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => "Xóa bản ghi thành công"] );
    }
}
