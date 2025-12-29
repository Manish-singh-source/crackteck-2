<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (! $request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login to access this resource.',
            ], 401);
        }

        $user = $request->user();

        // Check if user has any of the required roles
        if (! empty($roles)) {
            $hasRole = false;

            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    $hasRole = true;
                    break;
                }
            }

            if (! $hasRole) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. You do not have the required permissions to access this resource.',
                    'required_roles' => $roles,
                    'user_roles' => $user->getRoleNames()->toArray(),
                ], 403);
            }
        }

        return $next($request);
    }
}
