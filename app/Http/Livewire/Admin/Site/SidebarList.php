<?php

namespace App\Http\Livewire\Admin\Site;

use App\Http\Livewire\Base\BaseLive;
use Livewire\Component;

class SidebarList extends BaseLive
{
    public function mount(){
    }
    public function render(){
        return view('livewire.admin.site.sidebar-list');
    }
}
