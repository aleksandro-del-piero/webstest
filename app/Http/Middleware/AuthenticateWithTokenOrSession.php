<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithTokenOrSession
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if ($bearerToken) {
            $user = auth('sanctum')->user();

            if (!$user) {
                $this->throwUnauthenticatedException();
            }

            auth()->setUser($user);
            return $next($request);
        }

        if (auth('web')->check()) {
            return $next($request);
        }

        $this->throwUnauthenticatedException();
    }

    /**
     * @return void
     * @throws AuthenticationException
     */
    protected function throwUnauthenticatedException(): void
    {
        throw new AuthenticationException(__('validation.unauthenticated'));
    }
}
