<?php

namespace App\Http\Livewire\Admin\Faqs;
use App\Http\Livewire\Base\BaseLive;
use App\Models\Faq;
use App\Enums\EFaqTypeData;
class FaqsList extends BaseLive
{
    public $mode = 'create';
    public $editId;
    public $searchName;
    public $searchType;
    public $FaqType;

    public $question, $answer, $type, $category, $order_number=1;

    protected $listeners = [
        'setAnswer',
    ];
    public function mount(){
        $this->FaqType = EFaqTypeData::getListData();
    }
    public function render()
    {
        $query = Faq::query();
        if($this->searchName){
            $query = $query->where(function ($query) {
                $query->where("faqs.question", "like", "%".$this->searchName."%")
                    ->orWhere("faqs.answer", "like", "%".$this->searchName."%");
            });
        }
        if($this->searchType){
            $query->where("faqs.type", "like", $this->searchType);
        }

        $data = $query->orderBy('faqs.type','asc')->orderBy('faqs.order_number','asc')->paginate($this->perPage);
        return view('livewire.admin.faqs.faqs-list', [
            'data' => $data,
        ]);
    }
    public function resetValidate(){
        $this->question = "";
        $this->answer = "";
        $this->type = "";
        $this->category = "";
        $this->order_number = 1;
        $this->resetValidation();
    }
    public function create (){
        $this->mode = 'create';
        $this->editId = '';
        $this->emit('setEditor','');
    }
    public function edit($row){
        $this->mode = 'update';
        $this->editId = $row['id'];
        $this->question = $row["question"];
        $this->answer = $row["answer"];
        $this->type = $row["type"];
        $this->category = $row["category"];
        $this->order_number = $row["order_number"];
        $this->emit('setEditor',$row["answer"]);
    }
    public function standardData(){
        $this->question = trim($this->question);
        $this->answer = trim($this->answer);
        $this->type = trim($this->type);
        $this->category = trim($this->category);
        $this->order_number = trim($this->order_number);

    }

    public function resetSearch(){
        $this->searchName = '';
        $this->searchType = '';
        $this->resetPage();
    }

    public function updatedSearchName(){
        $this->resetPage();
    }
    public function updatedSearchType(){
        $this->resetPage();
    }
    public function delete() {
        Faq::findOrFail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => "Xóa bản ghi thành công"] );
    }

    public function saveData (){
        $this->standardData();

        $this->validate([
            'question' => 'required',
            'answer' => 'required',
            'type' => 'required',
            'order_number' => 'alpha_num|check_unique:'.$this->type.','.$this->editId.','.$this->order_number,
        ],[
            'question.required' => 'Câu hỏi bắt buộc',
            'answer.required' => 'Câu trả lời bắt buộc',
            'type.required' => 'Loại câu hỏi bắt buộc',
            'order.alpha_num' => 'Số thứ tự câu hỏi phải là số',
            'order.check_unique' => 'Số thứ tự đã tồn tại ở loại câu hỏi này',
        ]);
        if($this->mode=='create'){
            Faq::create([
                "question" => $this->question,
                "answer" => $this->answer,
                "type" => $this->type,
                "category" => $this->category,
                "order_number" => $this->order_number,
            ]);

        }
        else {
            Faq::where("id",$this->editId)->update([
                "question" => $this->question,
                "answer" => $this->answer,
                "type" => $this->type,
                "category" => $this->category,
                "order_number" => $this->order_number,
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

    public function setAnswer($data){
        $this->answer = $data;
        $this->saveData();
    }
}
