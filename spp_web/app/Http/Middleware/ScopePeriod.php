<?php

namespace App\Http\Middleware;

use App\Models\Program;
use App\Models\Request as ModelsRequest;
use Closure;
use Illuminate\Http\Request;

class ScopePeriod
{
    public function handle(Request $request, Closure $next)
    {
        $parameters = $request->route()->parameters();
        $periodId = null;
        if ($request->route()->hasParameter('period')) {
            $periodId = $parameters['period'];
        } else {
            $periodId = getCurrentPeriodId();
        }
        Program::addGlobalScope('current_period', function ($query) use ($periodId) {
            $query->where('period_id', $periodId);
        });
        ModelsRequest::addGlobalScope('current_period', function ($query) use ($periodId) {
            $query->where('period_id', $periodId);
        });
        return $next($request);
    }
}
