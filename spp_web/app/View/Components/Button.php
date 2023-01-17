<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $text;
    public $type;
    public $route;
    public $color;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $type, $route = '#', $color = 'primary', $class = 'btn mx-2 ')
    {
        //
        $this->text = $text;
        $this->type = $type;
        $this->route = $route;
        $this->color = $color;
        $this->class = $class . 'btn-' . $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
