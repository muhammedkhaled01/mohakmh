<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedEmail
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::withTrashed()->where('email', $request->email)->first();
        if (!$user) {
            $response = [
                'status' => false,
                'message' => 'User not found',
            ];
            return response()->json($response, 404);
        }

        if ($user->email_verified_at == null) {
            $response = [
                'status' => false,
                'message' => 'this account not verified',
            ];
            return response()->json($response, 400);
        }

        $response = $next($request);
        return $response;
    }
}
