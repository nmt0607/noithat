<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UnitItem extends Component
{
    public $value;
    public $key;
    // public $subchild;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value,$key)
    {
        $this->value = $value;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.unit-item');
    }
}
