<?php

namespace App\Http\Livewire\Admin\Site\Files;

use App\Models\File;
use Livewire\Component;

class FileEdit extends Component
{
    public $file;
    public $file_name;
    public $file_name_en;
    public $note;
    public $note_en;
    public $url;
    public $size_file;


    public function mount()
    {
        if ($this->file) {
            $this->file_name = $this->file->file_name ?? '';
            $this->file_name_en = $this->file->file_name_en ?? '';
            $this->note = $this->file->note ?? '';
            $this->note_en = $this->file->note_en ?? '';
            $this->url = $this->file->url ?? '';
            $this->size_file = $this->file->size_file ?? '';
        }
    }
    public function render()
    {
        return view('livewire.admin.site.files.file-edit');
    }
    public function edit()
    {
        $this->validate([
            'file_name' => 'required',
        ], [], [
            'file_name'=>'Tên file'
        ]);
        if ($this->file) {
            $this->file->file_name = $this->file_name;
            $this->file->file_name_en = $this->file_name_en;
            $this->file->note = $this->note;
            $this->file->note_en = $this->note_en;
            $this->file->save();
        }
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => "Cập nhật thành công"]);
        return redirect()->route('files.index');
    }
}
