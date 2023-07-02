<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductType;
use Illuminate\Support\Facades\Hash;

class ProductTypeList extends BaseLive
{
    public $mode = 'create';
    public $editId;
    public $deleteId;
    public $key_name='id', $sortingName='desc';
    public $name;
    public $parent_id;
    public $pdTypeParentList;
    protected $listeners = [
        'resetInput' => 'resetInput',
    ];


    protected $rules = [
        'name' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Họ và tên bắt buộc',
    ];


    public $search;
    public $searchName;
    public $searchPhone;
    public $searchSex;


    public function mount(){
        
        $this->perPage = 50;

    }

    public function render(){
        $this->pdTypeParentList = ProductType::where('parent_id', 0)->get()->pluck('name', 'id');
        $query = ProductType::query();

        if($this->searchName) {
            $query->where("name", "like", "%".$this->searchName."%");
        }

        $data = $query->orderBy($this->key_name,$this->sortingName)->paginate($this->perPage);
        return view('livewire.admin.product-type', [
            'data'=> $data,
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function resetValidate(){
        $this->name = "";
        $this->resetValidation();
    }

    public function create (){
        $this->mode = 'create';
        $this->resetInput();
    }
    public function resetInput(){
        $this->name = '';
        $this->parent_id = '';
    }

    public function saveData (){
        $this->name = trim($this->name);
        $this->rules['name'] = 'required';
        $this->validate();
        if($this->mode=='create'){
            $pdType = ProductType::create([
                "name" => $this->name,
                "parent_id" => $this->parent_id??0
            ]);

        }
        else {
            $pdType = ProductType::findorfail($this->editId);
            $pdType->update([
                "name" => $this->name,
                "parent_id" => $this->parent_id??0
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
        $this->name = $row["name"];
        $this->parent_id = $row["parent_id"]; 
    }

    public function delete(){
        ProductType::findorfail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Xóa thành công']);
    }

    public function resetSearch(){
        $this->search = "";
        $this->searchName = "";
        $this->searchPhone = "";
        $this->searchSex = "";
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
