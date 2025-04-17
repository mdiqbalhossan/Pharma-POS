<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDemo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (function_exists('app_mode') && app_mode() == 'demo') {
            $method = $request->method();
            if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
                return redirect()->back()->with('error', 'This action is restricted in demo mode');
            }
        }
        return $next($request);
    }
}
