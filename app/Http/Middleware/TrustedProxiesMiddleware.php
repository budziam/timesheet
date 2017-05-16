<?php
namespace App\Common\Http\Middleware;

use App\Common\UrlRemote;
use Cache;
use Closure;
use Request;

class TrustedProxiesMiddleware
{
    /**
     * Max age of cache in minutes
     *
     * @var int
     */
    protected $cacheMaxAge = 60 * 24;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cfipv4 = $this->getFromUrl('https://www.cloudflare.com/ips-v4');
        $cfipv6 = $this->getFromUrl('https://www.cloudflare.com/ips-v6');

        $proxies = collect()
            ->merge($cfipv4)
            ->merge($cfipv6)
            ->unique()
            ->filter(function ($value) {
                return strlen($value);
            })
            ->all();

        Request::setTrustedProxies($proxies);

        return $next($request);
    }

    /**
     * Returns value from given url with caching a query
     *
     * @param $url
     * @return array
     */
    protected function getFromUrl($url) : array
    {
        return Cache::remember($url, $this->cacheMaxAge, function () use ($url) {
            return explode(PHP_EOL, trim(UrlRemote::get($url)));
        });
    }
}
