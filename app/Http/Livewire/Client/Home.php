<?php

namespace App\Http\Livewire\Client;
use App\Http\Livewire\Base\BaseLive;
use App\Models\SignUpConsulation;
use App\Models\MasterData;
use App\Models\Product;
use App\Models\News;

class Home extends BaseLive
{

    public function render()
    {
        $banner = MasterData::where('type', 'Banner')->first();
        $productList = Product::where('type', 1)->take(6)->get();
        $newsList = News::query()->take(5)->get();
        $intro = MasterData::where('type', 'Giới thiệu')->first();
        return view('livewire.client.home', compact('banner', 'productList', 'newsList', 'intro'));
    }
}
