<?php

namespace App\Http\Livewire\Client;
use App\Http\Livewire\Base\BaseLive;
use App\Models\SignUpConsulation;
use App\Models\ProductType;

class Header extends BaseLive
{

    public $parentTypeList;

    public function render()
    {
        $this->parentTypeList = ProductType::where('parent_id', 0)->get();
        return view('livewire.client.header', [
            'parentTypeList'=> $this->parentTypeList,
        ]);
    }
}
