<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Period;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\Request as ModelsRequest;

class ScopePeriod
{
    public function handle(Request $request, Closure $next)
    {
        if (!activePeriodIsExists()) {
            return to_route('dashboard.setting.period.index')->with(
                [
                    'failed'    =>  'Buat periode baru terlebih dahulu'
                ]
            );
        }
        $period = $request->route()->hasParameter('period')
            ? Period::find($request->route()->parameter('period'))
            : getCurrentPeriod();
        // dd($period);
        ModelsRequest::addGlobalScope('current_period', function ($query) use ($period) {
            $query->where('period_id', $period->id)
                ->with(['program']); // Eager load the "program" relationship
        });

        Program::addGlobalScope('current_period', function ($query) use ($period) {
            $query->where('period_id', $period->id);
        });

        return $next($request);
    }
}
