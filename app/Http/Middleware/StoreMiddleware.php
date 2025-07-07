<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip middleware for specific routes
        $excludedRoutes = [
            'store.select',
            'store.set',
            'login',
            'logout',
            'register',
            'password.request',
            'password.reset',
            'password.email',
            'password.update',
            'verification.notice',
            'verification.verify',
            'verification.send',
        ];

        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        // Check if store is selected
        if (! session()->has('store_id')) {
            return redirect()->route('store.select');
        }

        return $next($request);
    }
}
