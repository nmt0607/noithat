<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Product;
use App\Models\User;
use App\Models\MasterData;
use App\Models\File;
use Illuminate\Support\Facades\Hash;

class MasterDataList extends BaseLive
{
    public $mode = 'create';
    public $editId;
    public $deleteId;
    public $key_name='id', $sortingName='desc';
    public $type;
    public $content;
    public $image;
    public $bannerId;
    public $introId;
    protected $listeners = [
        'resetInput' => 'resetInput',
    ];

    public $searchType;

    public function mount(){     
        $this->bannerId = MasterData::where('type', 'Banner')->first()->id;
        $this->introId = MasterData::where('type', 'Giới thiệu')->first()->id;
        $this->perPage = 10;
    }

    public function render(){
        $query = MasterData::query();

        if($this->searchType) {
            $query->where("type", $this->searchType);
        }

        $data = $query->orderBy($this->key_name,$this->sortingName)->paginate($this->perPage);
        return view('livewire.admin.master-data', [
            'data'=> $data,
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function resetValidate(){
        $this->type = "";
        $this->resetValidation();
    }

    public function create (){
        $this->mode = 'create';
        $this->resetInput();
    }
    public function resetInput(){
        $this->editId = null;
        $this->type = null;
        $this->content = null;
        $this->image = null;
    }

    public function saveData (){
        if($this->mode=='create'){
            $masterData = MasterData::create([
                "type" => $this->type,
                "content" => $this->content??null,
                "image" => $this->image??null
            ]);
            File::whereNull('model_id')->where('model_name','App\\Models\\MasterData')->update(['model_id'=>$masterData->id]);
        }
        else {
            $masterData = MasterData::findorfail($this->editId);
            $masterData->update([
                "type" => $this->type,
                "content" => $this->content??null,
                "image" => $this->image??null
            ]);
        }
        $this->resetValidate();
        if($this->mode=='create'){
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Thêm mới thành công']);
        }
        else {
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Chỉnh sửa thành công']);
        }
        $this->emit('closeModalCreateEdit');
    }

    public function edit($row){
        $this->mode = 'update';
        $this->editId = $row['id'];
        $this->type = $row["type"];
        $this->content = $row["content"]; 
    }

    public function delete(){
        MasterData::findorfail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Xóa thành công']);
    }

    public function resetSearch(){
        $this->reset('key_name');
        $this->reset('sortingName');
    }

    public function sorting($key){
        if($this->key_name == $key){
            $this->sortingName = $this->getSortName();
        } else {
            $this->sortingName ='desc';
        }
        $this->key_name = $key;
    }
    public function getSortName(){
        return $this->sortingName == "desc" ? "asc" : "desc";
    }
}
