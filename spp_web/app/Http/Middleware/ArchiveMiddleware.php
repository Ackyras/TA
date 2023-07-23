<?php

namespace App\Http\Middleware;

use App\Models\Program;
use App\Models\Request as ModelsRequest;
use Closure;
use Illuminate\Http\Request;

class ArchiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        ModelsRequest::disableGlobalScope('current_period');
        Program::disableGlobalScope('current_period');
        return $next($request);
    }
}
