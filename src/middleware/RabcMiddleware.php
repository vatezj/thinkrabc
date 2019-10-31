<?php
namespace Hualex\ThinkRabc\middleware;

use Hualex\ThinkRabc\service\NodeService;
use think\Facade\Request;
class RabcMiddleware
{
    public function handle($request, \Closure $next)
    {
        $module = app('http')->getName();
        $action = $request->pathinfo()?$request->pathinfo():"index/index";
        $node = $module.'/'.$action;
        $needAllSycNode = NodeService::getAllNeedSycNode();
        if(in_array($node,$needAllSycNode)){
            //查询session中是否有auth_id 无缺登录
            $auth_id = 16;
            if(!$auth_id)  return json('请登录');
            $managerNode = NodeService::getManagerNode($auth_id);
            $managerNode = array_column($managerNode, 'node');
            if(!in_array($node,$managerNode)) return json("您没有权限操作");
        }
        // TODO
        return $next($request);
    }

}