<?php
namespace App\Http\Middleware;

use App\Bases\BaseMiddleware;
use Auth;
use Closure;

class DashboardMiddleware extends BaseMiddleware
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
        if (!Auth::user()->can('enter', 'dashboard')) {
            return $request->expectsJson()
                ? $this->responseError(401)
                : redirect()->guest(route('app.home.index'));
        }

        return $next($request);
    }
}
