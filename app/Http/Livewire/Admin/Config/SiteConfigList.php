<?php

namespace App\Http\Livewire\Admin\Config;
use App\Http\Livewire\Base\BaseLive;
use App\Models\SiteConfig;
use App\Enums\ESiteConfigTypeData;
class SiteConfigList extends BaseLive
{
    public $mode = 'create';
    public $editId;
    public $searchName;
    public $searchType;

    public $SiteConfigType;

    public $type, $key, $order_number, $value, $value_en, $image;

    public function mount(){
        $this->SiteConfigType = ESiteConfigTypeData::getListData();
    }
    public function render()
    {
        $query = SiteConfig::query();
        if($this->searchName){
            $query = $query->where(function ($query) {
                $query->where("site_configs.value", "like", "%".$this->searchName."%")
                    ->orWhere("site_configs.key", "like", "%".$this->searchName."%")
                    ->orWhere("site_configs.value_en", "like", "%".$this->searchName."%");
            });
        }
        if($this->searchType){
            $query->where("site_configs.type", "like", $this->searchType);
        }

        $data = $query->paginate($this->perPage);
        return view('livewire.admin.config.site-config-list', [
            'data' => $data,
        ]);
    }
    public function resetValidate(){
        $this->type = "";
        $this->key = "";
        $this->order_number = "";
        $this->value = "";
        $this->value_en = "";
        $this->image = "";
        $this->resetValidation();
    }
    public function create (){
        $this->mode = 'create';
        $this->editId = '';
    }
    public function edit($row){
        $this->mode = 'update';
        $this->editId = $row['id'];
        $this->type = $row["type"];
        $this->key = $row["key"];
        $this->order_number = $row["order_number"];
        $this->value = $row["value"];
        $this->value_en = $row["value_en"];
        $this->image = $row["image"];
    }
    public function standardData(){
        $this->type = trim($this->type);
        $this->key = trim($this->key);
        $this->order_number = trim($this->order_number);
        $this->value = trim($this->value);
        $this->value_en = trim($this->value_en);
        $this->image = trim($this->image);

    }

    public function resetSearch(){
        $this->searchName = '';
        $this->searchType = '';
        $this->resetPage();
    }

    public function updatedSearchName(){
        $this->resetPage();
    }
    public function updatedSearchType(){
        $this->resetPage();
    }
    public function delete() {
        SiteConfig::findOrFail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => "Xóa bản ghi thành công"] );
    }

    public function saveData (){
        $this->standardData();

        $this->validate([
            'type' => 'required',
        ],[
            'type.required' => 'Type bắt buộc',
        ]);
        if($this->mode=='create'){
            SiteConfig::create([
                "type" => $this->type,
                "key" => $this->key,
                "order_number" => $this->order_number?$this->order_number:NULL,
                "value" => $this->value,
                "value_en" => $this->value_en,
                "image" => $this->image,
            ]);

        }
        else {
            SiteConfig::create([
                "type" => $this->type,
                "key" => $this->key,
                "order_number" => $this->order_number?$this->order_number:NULL,
                "value" => $this->value,
                "value_en" => $this->value_en,
                "image" => $this->image,
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

}
