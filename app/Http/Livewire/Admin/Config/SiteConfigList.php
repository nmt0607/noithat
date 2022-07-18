<?php

namespace App\Http\Livewire\Admin\Config;
use App\Http\Livewire\Base\BaseLive;
use App\Models\SiteConfig;
use App\Models\File;
use App\Enums\ESiteConfigTypeData;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
class SiteConfigList extends BaseLive
{
    use WithFileUploads;
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
        $this->emit('resetImage');
    }
    public function edit($row){
        $this->mode = 'update';
        $this->editId = $row['id'];
        $this->type = $row["type"];
        $this->key = $row["key"];
        $this->order_number = $row["order_number"];
        $this->value = $row["value"];
        $this->value_en = $row["value_en"];
        // $this->image = $row["image"];
        $this->emit('resetImage');
    }
    public function standardData(){
        $this->type = trim($this->type);
        $this->key = trim($this->key);
        $this->order_number = trim($this->order_number);
        $this->value = trim($this->value);
        $this->value_en = trim($this->value_en);

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
        $data = SiteConfig::findOrFail($this->deleteId);
        if($data->image&&file_exists('./'. $data->image)){
             unlink('./'. $data->image);
             File::where('model_id',$data->id)->where('model_name',SiteConfig::class)->delete();
        }
        $data->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => "Xóa bản ghi thành công"] );
    }

    public function saveData (){
        $this->standardData();

        $this->validate([
            'type' => 'required',
            // 'image' => 'image',
        ],[
            'type.required' => 'Type bắt buộc',
        ]);
        if($this->mode=='create'){

            $siteConfig = SiteConfig::create([
                "type" => $this->type,
                "key" => $this->key,
                "order_number" => $this->order_number?$this->order_number:NULL,
                "value" => $this->value,
                "value_en" => $this->value_en,
            ]);
            if($this->image){
                $model_name = SiteConfig::class;
                $folder = app($model_name)->getTable();
                $filePath = 'storage/'.$this->image->storeAs('uploads/' . $folder . '/files/' . auth()->id(), Str::random(20).time().'.'.$this->image->extension(), 'local');
    
                $this->saveFile($this->image, $siteConfig->id, $filePath, $model_name, $folder);
                $siteConfig->image = $filePath;
                $siteConfig->save();
            }

        }
        else {
            $siteConfig = SiteConfig::find($this->editId);
            $siteConfig->update([
                "type" => $this->type,
                "key" => $this->key,
                "order_number" => $this->order_number?$this->order_number:NULL,
                "value" => $this->value,
                "value_en" => $this->value_en,
            ]);
            if($this->image){
                if($siteConfig->image && file_exists('./'. $siteConfig->image)){
                    unlink('./'. $siteConfig->image);
                    File::where('model_id',$siteConfig->id)->where('model_name',SiteConfig::class)->delete();
                }
                $model_name = SiteConfig::class;
                $folder = app($model_name)->getTable();
                $filePath = 'storage/'.$this->image->storeAs('uploads/' . $folder . '/files/' . auth()->id(), Str::random(20).time().'.'.$this->image->extension(), 'local');
    
                $this->saveFile($this->image, $siteConfig->id, $filePath, $model_name, $folder);
                $siteConfig->image = $filePath;
                $siteConfig->save();
            }
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

    public function saveFile($file, $model_id, $filePath, $model_name, $folder){
        $originalName = $file->getClientOriginalName();

        $fileUpload = new File();
        $fileUpload->url = $filePath;
        $fileUpload->size_file = $this->getFileSize($file);
        $fileUpload->file_name = $originalName;
        $fileUpload->model_name = $model_name;
        $fileUpload->model_id = $model_id;
        $fileUpload->note = pathinfo($originalName,PATHINFO_FILENAME);
        $fileUpload->admin_id = auth()->check() ? auth()->id() : null;

        $fileUpload->save();
    }
    public function getFileSize($file) {
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

}
