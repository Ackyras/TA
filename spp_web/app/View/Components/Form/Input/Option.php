<?php

namespace App\View\Components\Form\Input;

use Illuminate\View\Component;

class Option extends Component
{
    public $name;
    public $options;
    public $selected;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $options, $title, $selected = null)
    {
        //
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input.option');
    }
}
