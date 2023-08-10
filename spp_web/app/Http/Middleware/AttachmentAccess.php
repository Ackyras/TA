<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AttachmentAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return $next($request);
    }
}
