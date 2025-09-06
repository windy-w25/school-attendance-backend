<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->user()->role, ['admin', 'teacher'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
