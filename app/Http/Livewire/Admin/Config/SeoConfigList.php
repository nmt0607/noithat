<?php

namespace App\Http\Livewire\Admin\Config;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Menu;

class SeoConfigList extends BaseLive
{
    public $menu_id, $name, $code, $permission_name, $alias, $note, $meta, $meta_en, $title_en, $title, $description, $description_en, $keywords, $keywords_en;

    public function render()
    {
        $query = Menu::query();
        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orwhere('alias', 'like', '%' . $this->searchTerm . '%')
                ->orwhere('meta', 'like', '%' . $this->searchTerm . '%')
                ->orwhere('title', 'like', '%' . $this->searchTerm . '%')
                ->orwhere('description', 'like', '%' . $this->searchTerm . '%')
                ->orwhere('keywords', 'like', '%' . $this->searchTerm . '%');
        }

        $data= $query->orderBy('created_at','desc')->paginate($this->perPage);
        return view('livewire.admin.config.seo-config-list', compact('data'));
    }

    public function edit($id) {
        $data = Menu::findorfail($id);
        $this->updateMode = true;
        $this->menu_id = $id;
        $this->name = $data->name;
        $this->code = $data->code;
        $this->permission_name = $data->permission_name;
        $this->alias = $data->alias;
        $this->note = $data->note;
        $this->meta = $data->meta;
        $this->meta_en = $data->meta_en;
        $this->title = $data->title;
        $this->title_en = $data->title_en;
        $this->description = $data->description;
        $this->description_en = $data->description_en;
        $this->keywords = $data->keywords;
        $this->keywords_en = $data->keywords_en;
    }

    public function update() {
        // $this->validate([

        // ]);
        $menu = Menu::findorfail($this->menu_id);
        $menu->name = $this->name;
        $menu->code = $this->code;
        $menu->permission_name = $this->permission_name;
        // $menu->alias = $this->alias;
        $menu->note = $this->note;
        $menu->meta = $this->meta;
        $menu->meta_en = $this->meta_en;
        $menu->title = $this->title;
        $menu->title_en = $this->title_en;
        $menu->description = $this->description;
        $menu->description_en = $this->description_en;
        $menu->keywords = $this->keywords;
        $menu->keywords_en = $this->keywords_en;

        $menu->save();
        $this->emit('close-modal-edit');
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('notification.common.success.update')] );
    }
}
