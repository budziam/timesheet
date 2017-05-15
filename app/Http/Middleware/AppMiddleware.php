<?php
namespace App\Http\Middleware;

use App\Bases\BaseMiddleware;
use Auth;
use Closure;

class AppMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            return $request->expectsJson()
                ? $this->responseError(401)
                : redirect()->guest(route('auth.login'));
        }

        return $next($request);
    }
}
