<?php

namespace App\View\Components\Form\Input;

use Illuminate\View\Component;
use App\View\Components\Form\Input\Input;

class Radio extends Input
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input.radio');
    }
}
