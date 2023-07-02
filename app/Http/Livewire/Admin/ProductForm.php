<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductType;
use App\Models\File;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class ProductForm extends BaseLive
{
    use WithFileUploads;

    public $pdTypeList;
    public $name;
    public $code;
    public $material;
    public $status;
    public $guarantee;
    public $price;
    public $pd_type_lv1;
    public $editId;
    public $type = 0;
    public $mode ='create';
    public $images;
    public $listeners = [
        'changeType', 'chooseAvatar'
    ];

    public function mount(){
        File::where('model_id', 0)->delete();
        if($this->editId){
            $pd = Product::findOrFail($this->editId);
            $this->name = $pd->name;
            $this->code = $pd->code;
            $this->material = $pd->material;
            $this->status = $pd->status;
            $this->guarantee = $pd->guarantee;
            $this->price = $pd->price;
            $this->pd_type_lv1 = $pd->pd_type_lv1;
            $this->type = $pd->type;
            
        }
        $this->pdTypeList = ProductType::where('parent_id','!=', 0)->get()->pluck('name', 'id');
        $this->perPage = 50;
    }

    public function render(){
        $this->images = File::where('model_id', $this->editId)->get();
        $query = Product::query();
        $data = $query->paginate($this->perPage);
        return view('livewire.admin.product-form', ['data'=> $data,]);
    }

    public function save(){
        $pdType = ProductType::find($this->pd_type_lv1);
        if($this->editId){
            $pd = Product::findOrFail($this->editId);
            $pd->update([
                "name" => $this->name,
                "code" => $this->code,
                "material" => $this->material,
                "status" => $this->status,
                "guarantee" => $this->guarantee,
                "price" => $this->price,
                "pd_type_lv1" => $this->pd_type_lv1,
                "pd_type_lv2" => $pdType?$pdType->parent_id:'',
                "type" => $this->type,
            ]);

            
        }
        else {
            $pd =  Product::create([
                "name" => $this->name,
                "code" => $this->code,
                "material" => $this->material,
                "status" => $this->status,
                "guarantee" => $this->guarantee,
                "price" => $this->price,
                "pd_type_lv1" => $this->pd_type_lv1,
                "pd_type_lv2" => $pdType?$pdType->parent_id:'',
                "type" => $this->type,
            ]);
            File::where('model_id', 0)->update(['model_id'=>$pd->id]);

        }
        return redirect()->route('admin.product');
    }

    public function delete(){
        File::findorfail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Xóa thành công']);
    }

    public function chooseAvatar($id){
        File::where('model_id', $this->editId)->update(['type' => 0]);
        File::findorfail($id)->update(['type' => 1]);
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Đã chọn ảnh đại diện']);
    }

    public function saveImage(){
        $this->emit('close-modal');
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Thêm hình ảnh thành công']);
    }

    public function changeType(){
        $this->type = $this->type==1?0:1;
    }
}
