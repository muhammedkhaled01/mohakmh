<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('api_key');

        /* if ($apiKey != config('app.api_key')) {
            return abort(403, 'Unauthorized');
        } */

        if ($request->header('api_key') != config('app.api_key')) {
            return abort(403, 'Unauthorized');
        }

        $response = $next($request);
        return $response;
        //dd($response);
    }
}
