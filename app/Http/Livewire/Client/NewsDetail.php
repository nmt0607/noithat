<?php

namespace App\Http\Livewire\Client;
use App\Http\Livewire\Base\BaseLive;
use App\Models\News;

class NewsDetail extends BaseLive
{
    public $newsId;
    public function render()
    {
        $news = News::findOrFail($this->newsId);
        $newsRelated = News::where('category', $news->type)->get();
        $newsList = News::all()->take(5);
        return view('livewire.client.news-detail', compact('news', 'newsRelated', 'newsList'));
    }
}
