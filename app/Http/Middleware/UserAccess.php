<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        // Admins can access everything
        if ($user->role == 2 && $user->status == 1) {
            return $next($request);
        }

        // Practitioners should not access admin pages
        if ($user->role == 1 && $user->status == 1 && $userType !== 'admin') {
            return $next($request);
        }

//        if ($user->role == 0 && $user->status == 1 && ($userType !== 'admin' && $userType !== 'practitioner')) {
//            return $next($request);
//        }

        return response()->json(['message' => 'You do not have permission to access this page.'], 403);
    }
}
