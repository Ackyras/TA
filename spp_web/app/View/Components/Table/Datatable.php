<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class Datatable extends Component
{
    public $table;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($table)
    {
        //
        $this->table = $table;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.datatable');
    }
}
