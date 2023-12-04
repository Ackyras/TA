<?php

namespace App\View\Components\Form\Input;

use Illuminate\View\Component;

class Password extends Component
{
    public $name;
    public $title;
    public $value;
    public $hidden;
    public $disabled;
    public $inLine;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title, $value = null, $hidden = false, $disabled = false, $inLine = false)
    {
        //
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
        $this->hidden = $hidden;
        $this->disabled = $disabled;
        $this->inLine = $inLine;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input.text');
    }
}
