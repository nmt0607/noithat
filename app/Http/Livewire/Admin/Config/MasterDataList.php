<?php

namespace App\Http\Livewire\Admin\Config;

use App\Enums\EMasterData;
use Livewire\Component;
use App\Models\MasterData;
use App\Http\Livewire\Base\BaseLive;
use Laravel\Passport\HasApiTokens;
use Livewire\WithFileUploads;

class MasterDataList extends BaseLive
{
    use WithFileUploads;
    public $selectedtypes = [];
    public $status = false ;
    public $vkey ;
    public $vvalue  ;
    public $vvalueen  ;
    public $ordernumber ;
    public $parentid  ;
    public $type  ;
    public $ID ;
    public $searchTerm ;
    public $typeFilter;
    public $content;
    public $content_en;
    public $note;
    public $note_en;
    public $url;
    public $image;
    public $remove_path;
    public $remove;
    public $change_image = false;
    public $number_value;
    public $dataSortable=[];
    public function removeall()
    {
        $this->status=true;
    }

    protected $listeners = [
        'set-note-create' => 'setNoteCreate',
        'set-note-update' => 'setNoteUpdate',
        'remove_path' => 'removePath',
    ];

    public function mount(){
        // $this->checkDestroyPermission = checkRoutePermission('destroy');
        // $this->checkCreatePermission = checkRoutePermission('create');
        // $this->checkEditPermission = checkRoutePermission('edit');
    }

    public function render()
    {
        $data = MasterData::query();
        if($this->searchTerm) {
            $data->where('v_key', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('url', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('v_value', 'like', '%' . trim($this->searchTerm) . '%')
                ->orWhere('v_value_en', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('v_content', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('v_content_en', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('note','like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('note_en','like', '%' . trim($this->searchTerm) . '%');
        }
        if($this->typeFilter) {
            $data->where('type', $this->typeFilter);
            $data->orderBy('order_number');
        }else{
            $data->orderBy('id','DESC');
        }
        $data = $data->paginate($this->perPage);
        $dataType = EMasterData::getListData();
        if($data->total()>0){
            $arrSortable = $data->toArray();
            $this->dataSortable=$arrSortable['data'];
        }

        $this->emit('setEditorCreate');
        return view('livewire.admin.config.master-data-list', ['category' => $data, 'dataType' => $dataType]);
    }
    public function resetform()
    {
        $this->vkey = null;
        $this->vvalue = null;
        $this->vvalueen = null;
        $this->ordernumber = null;
        $this->type = null;
        $this->parentid = null;
        $this->content = null;
        $this->content_en = null;
        $this->url = null;
        $this->image =null;
        $this->remove_path = null;
        $this->change_image = false;
        $this->searchTerm = null;
        $this->number_value = null;
    }

    public function store()
    {
        $this->validate([
            'vkey'=>'required',
            'type'=>'required',
            // 'image' => 'image|max:1024'
        ],[ 
            'vkey.required' => 'Data type name bắt buộc',
            'type.required' => 'Value type bắt buộc',
        ]);

        $master = new MasterData;
        $master->v_key = $this->vkey;
        $master->v_value = $this->vvalue;
        $master->v_value_en = $this->vvalueen;
        $master->order_number = $this->ordernumber;
        $master->type = $this->type;
        $master->parent_id = $this->parentid;
        $master->v_content = $this->content;
        $master->v_content_en = $this->content_en;
        $master->note = $this->note;
        $master->note_en = $this->note_en;
        $master->url = $this->url;
        $master->number_value = ($this->number_value) ? $this->number_value : null;
        $master->image =$this->image ? $this->image->storeAs('public/photos', $this->image->getClientOriginalName()) : null;
        $master->save();
        $this->emit('close-modal-create');
        $this->resetform();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('notification.common.success.add')] );
    }

    public function delete()
    {
       MasterData::findOrFail($this->deleteId)->delete();
       $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('notification.common.success.delete')] );
    }

    public function edit($id)
    {
        $master = MasterData::findOrFail($id);
        $this->ID = $master->id;
        $this->vkey = $master->v_key;
        $this->vvalue = $master->v_value;
        $this->type = $master->type;
        $this->vvalueen= $master->v_value_en ;
        $this->parentid = $master->parent_id;
        $this->content= $master->v_content ;
        $this->content_en = $master->v_content_en;
        $this->note= $master->note ;
        $this->ordernumber=$master->order_number;
        $this->note_en = $master->note_en;
        $this->url = $master->url;
        $this->number_value = $master->number_value;
        $this->image = $master->image;
        $this->resetValidation();
        $this->emit('setEditor', $master->note, $master->note_en, $master->v_content, $master->v_content_en);
    }

    public function update()
    {
        $this->validate([
            'vkey'=>'required',
            'type'=>'required',
        ],[ 
            'vkey.required' => 'Data type name bắt buộc',
            'type.required' => 'Value type bắt buộc',
        ]);
        $id = $this->ID;
        $master=MasterData::findOrFail($id);
        $master->v_key = $this->vkey;
        $master->v_value = $this->vvalue;
        $master->v_value_en = $this->vvalueen;
        $master->order_number = $this->ordernumber;
        $master->type = $this->type;
        $master->parent_id = $this->parentid;
        $master->v_content = $this->content;
        $master->v_content_en = $this->content_en;
        $master->note = $this->note;
        $master->note_en = $this->note_en;
        $master->url = $this->url;
        $master->number_value = ($this->number_value) ? $this->number_value : null;
        if(isset($this->remove_path) && $this->remove_path){
            if(file_exists('./storage/'. $master->image)){
                unlink('./storage/'. $master->image);
            }
            $master->image = null;
        }
        if ($this->change_image && $this->image) {
            $master->image =$this->image->storeAs('public/photos', $this->image->getClientOriginalName());
        }
        $master->save();
        $this->resetform();
        $this->emit('close-modal-edit');
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('notification.common.success.update')] );
    }

    public function setNoteCreate($note, $note_en, $content, $content_en) {
        // dd($note, $note_en, $content, $content_en);
        $this->note = $note;
        $this->note_en = $note_en;
        $this->content= $content;
        $this->content_en = $content_en;
        $this->store();
    }

    public function setNoteUpdate($note, $note_en, $content, $content_en) {
        $this->note = $note;
        $this->note_en = $note_en;
        $this->content= $content;
        $this->content_en = $content_en;
        $this->update();
    }

    public function removePath() {
        $this->remove_path = $this->image;
        $this->image = null;
        $this->change_image = true;
    }
    public function updateOrder($list){
        if($this->typeFilter){
            foreach ($this->dataSortable as $key_o=> $value_o){
                foreach ($list as $key_n=> $value_n) {
                    if($key_o==$key_n&& $value_n['value']!=$value_o['order_number']){
                        MasterData::where('id',$value_o['id'])->update(['order_number'=>$value_n['value']? $value_n['value']:null]);
                    }
                }
            }
        }
    }
}
