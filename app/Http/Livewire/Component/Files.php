<?php

namespace App\Http\Livewire\Component;

use App\Http\Livewire\Base\BaseLive;
use App\Models\File;
use Livewire\WithFileUploads;

class Files extends BaseLive
{

    use WithFileUploads;
    public $name;
    public $file;
    public $url;
    public $model_name;
    public $folder;
    public $model_id;
    public $type;
    public $file_name;
    public $status;
    public $note;
    public $canUpload = true;
    public $canDownload = true;
    public $uploadOnShow = 0;
    public $deleteUnknownFilesOnMount = true;
    public $disabled;
    public $displayUploadfile = true;
    public $displayFile = true;
    public $maximumFileSize = 255; // Mb
    public $maximumUploads = 5;
    public $acceptMimeTypes;

    public $files = [];

    protected $listeners = [
        'updateFile' => 'render',
        'resetFilesComment' => 'resetFilesComment',
    ];

    public function rules() {
        return [
            'file' => [
                'file',
                'mimes:' . implode(',', $this->acceptMimeTypes),
                'max:' . $this->maximumFileSize * 1024
            ],
            'files' => [
                'array',
                // 'max:' . ($this->maximumUploads - 1)
            ]
        ];
    }

    protected function getMessages()
    {
        return [
            'file.mimes' => __('notification.upload.mime_type'),
            'file.max' => __('notification.upload.maximum_size', ['value' => $this->maximumUploads]),
            // 'files.max' => __('notification.upload.maximum_uploads')
        ];
    }

    public function mount()
    {
        if (empty($this->acceptMimeTypes)) {
            $this->acceptMimeTypes = config('common.mime_type.general', []);
        }

        if (empty($this->name)) {
            $this->name = 'Đính kèm file';
        }

        if($this->deleteUnknownFilesOnMount) {
            $this->deleteUnknownFiles();
        }
    }
    public function resetFilesComment(){
        if($this->canUpload){
            $this->reset('file','files');
        }
    }

    public function render()
    {

        $this->files = File::query()
            ->where('model_name', $this->model_name)
            ->where('type', $this->type)
            ->where('model_id', $this->model_id)
            ->get()
            ->keyBy('id')
            ->toArray();
        if ($this->uploadOnShow == 0 && checkShowMode()) {
            $this->canUpload = false;
        }
        return view('livewire.component.files');
    }

    public function updatedFile()
    {

        $this->validate();

        $originalName = $this->file->getClientOriginalName();
        $filePath = $this->file->storeAs('uploads/' . $this->folder . '/files/' . auth()->id(), $this->file->getFilename(), 'local');

        $fileUpload = new File();
        $fileUpload->url = $filePath;
        $fileUpload->size_file = $this->getFileSize($this->file);
        $fileUpload->file_name = $originalName;
        $fileUpload->model_name = $this->model_name;
        $fileUpload->model_id = $this->model_id;
        $fileUpload->note = pathinfo($originalName,PATHINFO_FILENAME);
        $fileUpload->admin_id = auth()->check() ? auth()->id() : null;
        if ($this->status == -1) {
            $fileUpload->status = -1;
        }
        $fileUpload->type = $this->type;
        $fileUpload->save();
    }

    public function deleteFile($id)
    {
        $data = File::findorfail($id);
        if (!empty($data)) {
            unlink(storage_path('app/'.$data->url));
            $data->delete();
        }
    }

    public function deleteUnknownFiles()
    {
        $deltefiles = File::query()->where('admin_id', auth()->id())->whereNull('model_id')->get();
        foreach($deltefiles as $file){
            unlink(storage_path('app/'.$file->url));
            $file->delete();
        }
    }

    public function getFileSize($file) {
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
