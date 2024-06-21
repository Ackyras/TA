<?php

namespace App\View\Components\Form\Input;

use Illuminate\View\Component;

class Checkbox extends Input
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input.checkbox');
    }
}
