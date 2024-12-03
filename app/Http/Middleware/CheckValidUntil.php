<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckValidUntil
{
    public function handle(Request $request, Closure $next): Response
    {
        $validUntil = session('valid_until');

        if (!$validUntil || now()->greaterThan($validUntil)) {
            app(UserService::class)->logout();
            return redirect()->route('user.register')->withErrors(['error' => 'Session expired. Please log in again.']);
        }

        return $next($request);
    }
}
