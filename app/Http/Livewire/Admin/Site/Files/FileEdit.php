<?php

namespace App\Http\Livewire\Admin\Site\Files;

use App\Models\File;
use App\Models\User;
use Livewire\Component;

class FileEdit extends Component
{

    public $note;
    public $file;
    public function mount(){
        if ($this->file) {
            $this->note = $this->file->note ?? '';
        }
    }
    public function render(){
        $user = User::find($this->file->admin_id);
        $user_name = $user?$user->name:'';
        return view('livewire.admin.site.files.file-edit',[
            'user_name' => $user_name,
        ]);
    }
    public function edit(){
        if ($this->file) {
            $this->file->note = $this->note;
            $this->file->save();
        }
        return redirect()->route('admin.files.index')->with('success', 'Cập nhật thành công');;
    }
}
