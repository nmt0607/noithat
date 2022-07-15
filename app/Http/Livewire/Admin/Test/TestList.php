<?php

namespace app\Http\Livewire\Admin\Test;

use Livewire\Component;
use App\Http\Livewire\Base\BaseLive;
use App\Models\Test;
use Excel;
use App\Exports\TestExport;


class TestList extends BaseLive {

    public $mode = 'create';
    public $editId;
    public $deleteId;
    public $key_name='id', $sortingName='desc';
    public $name;
    public $contract_number;
    public $actor_name;
    public $director;
    public $status;

    public $items = [];

    protected $rules = [
        'name' => 'required',
        'contract_number' => 'required',
        'actor_name' => 'required',
        'director' => 'required',
        'status' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Tên sản phẩm bắt buộc',
        'contract_number.required' => 'Số hợp đồng bắt buộc',
        'actor_name.required' => 'Đạo diễn bắt buộc',
        'director.required' => 'Giám đốc bắt buộc',
        'status.required' => 'Trạng thái bắt buộc',
    ];

    public $search;
    public $searchActorName;
    public $searchDirector;
    public $searchStatus;

    public function mount(){
        $this->perPage = 50;
    }

    public function render(){
        $query = $this->getQuery();
        $data = $query->orderBy($this->key_name,$this->sortingName)->paginate($this->perPage);
        return view('livewire.admin.test.test-list', [
            'data'=> $data,
        ]);
    }

    public function getQuery(){
        $query = Test::query();
        if($this->search) {
            $query = $query->where(function ($query) {
                $query->where("name", "like", "%".$this->search."%")->orWhere('contract_number', 'like', '%'.$this->search.'%');
            });
        }

        if($this->searchActorName) {
            $query->where("actor_name", "like", "%".$this->searchActorName."%");
        }
        if($this->searchDirector) {
            $query->where("director", "like", "%".$this->searchDirector."%");
        }
        if($this->searchStatus) {
            $query->where("status", "like", "%".$this->searchStatus."%");
        }

        return $query;
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function resetValidate(){
        $this->name = "";
        $this->contract_number = "";
        $this->actor_name = "";
        $this->director = "";
        $this->status = "";
        $this->resetValidation();
    }

    public function create (){
        $this->mode = 'create';
    }

    public function saveData (){
        $this->standardData();
        $this->validate();
        if($this->mode=='create'){
            Test::create([
                "name" => $this->name,
                "contract_number" => $this->contract_number,
                "actor_name" => $this->actor_name,
                "director" => $this->director,
                "status" => $this->status,
            ]);

        }
        else {
            Test::where("id",$this->editId)->update([
                "name" => $this->name,
                "contract_number" => $this->contract_number,
                "actor_name" => $this->actor_name,
                "director" => $this->director,
                "status" => $this->status,
            ]);

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

    public function edit($row){
        $this->mode = 'update';
        $this->editId = $row['id'];
        $this->name = $row["name"];
        $this->contract_number = $row["contract_number"];
        $this->actor_name = $row["actor_name"];
        $this->director = $row["director"];
        $this->status = $row["status"];

    }

    
    
    public function standardData(){
        $this->name = trim($this->name);
        $this->contract_number = trim($this->contract_number);
        $this->actor_name = trim($this->actor_name);
        $this->director = trim($this->director);
        $this->status = trim($this->status);

    }

    public function delete(){
        Test::findorfail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Xóa thành công']);
    }

    public function deleteAll(){
        $query = $this->getQuery();
        $itemIds = $query->whereIn("test.id",$this->items)->pluck("id")->toArray();
        $query = Test::whereIn("test.id",$itemIds)->delete();
        $countDelete = count($itemIds);
        $this->items = array_diff($this->items, $itemIds);
        $this->dispatchBrowserEvent("show-toast", ["type" => "success", "message" => "Xóa thành công ".$countDelete." bản ghi."]);
    }

    public function resetSearch(){
        $this->search = "";
        $this->searchActorName = "";
        $this->searchDirector = "";
        $this->searchStatus = "";
        $this->reset('key_name');
        $this->reset('sortingName');
    }

    public function export(){
        $today = date("d_m_Y");
        return Excel::download(new TestExport($this->key_name, $this->sortingName, $this->search, $this->searchActorName, $this->searchDirector, $this->searchStatus), "Test-export-".$today.".xlsx");
    }

    public function sorting($key){
        if($this->key_name == $key){
            $this->sortingName = $this->getSortName();
        } else {
            $this->sortingName ='desc';
        }
        $this->key_name = $key;
    }
    public function getSortName(){
        return $this->sortingName == "desc" ? "asc" : "desc";
    }
    
}
