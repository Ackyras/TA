<?php

namespace App\View\Components\Form\Input;

use Illuminate\View\Component;

abstract class Input extends Component
{
    public $name;
    public $title;
    public $value;
    public $hidden;
    public $inLine;
    public $checked;
    public $id;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title, $id = null, $value = null, $hidden = false, $inLine = false, $checked = false, $disabled = false)
    {
        //
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
        $this->hidden = $hidden;
        $this->inLine = $inLine;
        $this->checked = $checked;
        $this->id = $id == null ? $name : $id;
        $this->disabled = $disabled;
    }
}
