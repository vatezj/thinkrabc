<?php
namespace Hualex\ThinkRabc\middleware;

class RabcMiddleware
{
    public function handle($request, \Closure $next)
    {
        // TODO
        return $next($request);
    }

}