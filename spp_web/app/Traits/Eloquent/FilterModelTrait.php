<?php

namespace App\Traits\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

trait FilterModelTrait
{
    public function filter($query, Request $request, bool $exact = false, $paginate = null, $perPage = 10)
    {
        $datas = QueryBuilder::for($query, $request)
            ->allowedFilters($exact ? $this->exactFilter($this->allowedFilters) : $this->allowedFilters);

        if ($paginate) {
            $datas = $datas->paginate($perPage, [
                'path'  =>  $request->fullUrl()
            ]);
        } else {
            $datas = $datas->get();
        }

        return $datas;
    }


    public function exactFilter(array $filters)
    {
        $exactFilters = [];
        foreach ($filters as $filter) {
            $exactFilters[] = AllowedFilter::exact($filter);
        }
        return $exactFilters;
    }
}
