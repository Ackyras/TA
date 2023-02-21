<?php

namespace App\Traits\Datatables\V1;

use App\Exceptions\Datatable\DatatableConfigurationFormatException;

trait DatatableTrait
{
    public function prepare(array $config, array $datas, bool $isShowOnlyRequiredData = false)
    {
        $datatable = $config;

        if ($isShowOnlyRequiredData) {
            foreach ($datas as $data) {
                foreach ($config['headers'] as $key => $attribute) {
                    $row[$key] = $data[$attribute];
                }
                $datatable['rows'][] = $row;
            }
        } else {
            $datatable['rows'] = $datas;
        }
        // dd($datatable);

        return $datatable;
    }

    // public function customizeActions(array $actions)
    // {
    //     if (!is_null($actions)) {
    //         foreach ($actions as $action) {
    //             if(isset($action['']))
    //         }
    //     }
    //     return $actions;
    // }
}
