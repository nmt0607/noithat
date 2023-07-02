<?php

namespace App\Http\Livewire\Client;
use App\Http\Livewire\Base\BaseLive;
use App\Models\Product;
use App\Models\ProductType;

class ProductDetail extends BaseLive
{
    public $productId;

    public function render()
    {
        $product = Product::findOrFail($this->productId);
        $productRelated = Product::where('pd_type_lv2', $product->pd_type_lv2)->get();
        return view('livewire.client.product-detail', compact('product', 'productRelated'));
    }
}
