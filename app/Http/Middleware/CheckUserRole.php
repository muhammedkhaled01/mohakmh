<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        $user = $request->user(); // return object of current user make login
        if (!$user) {
            return redirect()->route('login');
        }
        if (!in_array($user->role, $role)) {
            abort(403);
        };

        $response = $next($request);
        return $response;
        //dd($response);
    }
}
