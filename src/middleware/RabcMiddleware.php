<?php
namespace Hualex\ThinkRabc\middleware;

class RabcMiddleware
{
    public function handle($request, \Closure $next)
    {
        // TODO
        echo 1;
        return $next($request);
    }

}