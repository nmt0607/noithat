<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (method_exists($user, 'isAllowedAtRoute') && !$user->isAllowedAtRoute()) {
            // return redirect()->route('error.403');
            throw new UnauthorizedHttpException('Hello', '', null, 403);
        }

        return $next($request);
    }
}
