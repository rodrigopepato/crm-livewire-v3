<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShouldBeVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->email_verified_at == null) {
            return to_route('auth.email-validation');
        }

        return $next($request);
    }
}
