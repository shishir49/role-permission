<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePermissionCheckMiddleware
{
    public function handle(Request $request, Closure $next, $roleOrPermission)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        if (!$user->hasAnyRole(explode('|', $roleOrPermission)) && !$user->hasAnyPermission(explode('|', $roleOrPermission))) {
            // return response()->json($roleOrPermission);
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
