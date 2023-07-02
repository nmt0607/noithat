<?php

namespace App\Http\Livewire\Client;
use App\Http\Livewire\Base\BaseLive;
use App\Models\ProductType;
use App\Models\Product;

class ProductList extends BaseLive
{

    public $typeId;
    public $typeName;

    public function render()
    {
        $query = Product::query();
        if(isset($_GET['type_id'])){
            $this->typeId = ($_GET['type_id']);
            $this->typeName = ProductType::findOrFail($this->typeId)->name;
            $query = $query->where('pd_type_lv1', $this->typeId)->orWhere('pd_type_lv2', $this->typeId);
        }
        else{
            $query = $query->where('type', 1);
        }
        $data = $query->get();
        $listPdType = ProductType::whereNull('parent_id')->orWhere('parent_id', 0)->get();
        return view('livewire.client.product-list', compact('data', 'listPdType'));
    }
}
