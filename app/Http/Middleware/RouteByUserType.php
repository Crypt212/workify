<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RouteByUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( Auth::guest()) {
            return redirect()->route('login.page');
        }
        // Skip if already going to role-specific route
        if (
            str_starts_with($request->path(), 'employer/') ||
            str_starts_with($request->path(), 'seeker/')
        ) {
            return $next($request);
        }

        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        $routeName = match ($user->identity) {
            'employer' => 'employer.' . $request->route()->getName(),
            'seeker' => 'seeker.' . $request->route()->getName()
        };

        // Only redirect if not already going to correct route
        if ($request->route()->getName() !== $routeName) {
            return redirect()->route($routeName);
        }

        return $next($request);
    }
}
