<?php

namespace App\Http\Livewire\Admin\QuestionCustomer;
use App\Http\Livewire\Base\BaseLive;
use App\Models\QuestionOfCustomer as question;

class QuestionOfCustomer extends BaseLive
{
    public $searchName;
    public $searchIp;
    public function render()
    {
        $query = question::query();
        if($this->searchName){
            $query = $query->where(function ($query) {
                $query->where('phone', 'like', '%'. $this->searchName .'%')
                    ->orWhere('email', 'like', '%'. $this->searchName .'%');
            });
        }
        if($this->searchIp){
            $query = $query->where('IP','like',"%$this->searchIp%");
        }

        $data = $query->orderBy('created_at', 'desc')->paginate($this->perPage);
        return view('livewire.admin.question-customer.question-customer-list',[
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
