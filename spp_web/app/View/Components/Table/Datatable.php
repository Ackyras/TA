<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class Datatable extends Component
{
    public $table, $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($table, $id = 'datatable')
    {
        // dd($table);
        $this->table = $table;
        $this->id = $id;
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

    public function getActionParameter(array $action, array $row)
    {
        $actionParameters = [];
        if (isset($action['routeParameter'])) {
            foreach ($action['routeParameter'] as $key =>   $value) {
                $actionParameters[$key]  =  $row[$value];
            }
        } else {
            $actionParameters = $row['id'];
        }
        return $actionParameters;
    }
}
