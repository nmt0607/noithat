<?php

namespace App\Http\Livewire\Admin\Advise;
use App\Http\Livewire\Base\BaseLive;
use App\Models\SignUpConsulation;

class AdviseList extends BaseLive
{
    public $searchName;
    public $searchIp;
    public function render()
    {
        $query = SignUpConsulation::query();
        if($this->searchName){
            $query = $query->where(function ($query) {
                $query->where('name', 'like', '%'. $this->searchName .'%')
                    ->orWhere('phone', 'like', '%'. $this->searchName .'%')
                    ->orWhere('email', 'like', '%'. $this->searchName .'%');
            });
        }
        if($this->searchIp){
            $query = $query->where('IP',$this->searchIp);
        }

        $data = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        return view('livewire.admin.advise.advise-list',[
            'data' => $data
        ]);
    }

    public function resetSearch(){
        $this->searchName = '';
        $this->searchIp = '';
        $this->resetPage();
    }
    public function updatedSearchName(){
        $this->resetPage();
    }
    public function updatedSearchIp(){
        $this->resetPage();
    }
}
