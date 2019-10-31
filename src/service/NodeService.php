<?php
namespace Hualex\ThinkRabc\service;
use Hualex\ThinkRabc\model\Auth;
use Hualex\ThinkRabc\model\Node;
use Hualex\ThinkRabc\service\ToolsService;
use function MongoDB\BSON\fromJSON;
use think\facade\Config;
use think\facade\Db;

class NodeService{
    /**
     * @desc 重复节点删除
     * @param $arr
     * @param $key
     * @return mixed
     */
    private static function assoc_title($arr, $key)
    {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        return $arr;
    }
    /**
     * @desc  获取当前管理员的权限
     *
     */
    public static function getManagerNode($auth_id){
        $list = Auth::with('roles')->where(['auth_id'=>$auth_id])->select();

        $res = $list->hidden(["roles"=>["pivot"]])->toArray();
        if(!$res) return [];
        return self::assoc_title($res[0]['roles'],'node');
    }
    /**
     * @desc  获取当前管理员的权限
     *
     */
    public static function getAllNeedSycNode(){
        return Db::name('node')->where(['is_auth'=>1])->select()->column('node');
    }
    /**
     * @desc 给管理员授权节点
     * @param $auth_id
     * @param $nodeArr
     * @return mixed
     */
    public static function authorizeNode($auth_id,$nodeArr){
        $save = [];
        foreach ($nodeArr as $k=>$v){
            $save[$k]['auth_id'] = $auth_id;
            $save[$k]["node_id"] = $v;
        }
        $status = false;
        Db::startTrans();
        try {
            Db::name('auth_node')->where(["auth_id"=>$auth_id])->delete();
            Db::name('auth_node')->insertAll($save);
            // 提交事务
            Db::commit();
            $status = true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        return $status;
    }

    /**
     * @desc 将节点数组转换成table数组
     * @return array
     */
    public static function getNode():array {
        $module = "admin";
        $nodes = ToolsService::arr2table(self::getTree([], [], $module), 'node', 'pnode');
        $groups = [];
        foreach ($nodes as $node) {
            $pnode = explode('/', $node['node'])[0];
            if ($node['node'] === $pnode) {
                $groups[$pnode]['node'] = $node;
            }
            $groups[$pnode]['list'][] = $node;
        }
       return $groups;
    }

    /**
     * @desc 获取应用下的方法
     * @param $module
     * @return array
     */
    private static function getTree($where,$ignore,$module):array {
        $path = app()->getAppPath();
        if ($module) {
            $path .= $module;
        }
        $nodes = [];
        $alias = Db::name('node')->where($where)->column('node,is_auth,title,id');
        foreach (self::getNodeTree($path) as $thr) {
            foreach ($ignore as $str) {
                if (stripos($thr, $str) === 0) {
                    continue 2;
                }
            }
            $tmp = explode('/', $thr);
            list($one, $two) = ["{$tmp[0]}", "{$tmp[0]}/{$tmp[1]}"];
            $nodes[$one] = array_merge(isset($alias[$one]) ? $alias[$one] : ['node' => $one, 'title' => '','is_auth' => 0, ], ['pnode' => '']);
            $nodes[$two] = array_merge(isset($alias[$two]) ? $alias[$two] : ['node' => $two, 'title' => '','is_auth' => 0], ['pnode' => $one]);
            $nodes[$thr] = array_merge(isset($alias[$thr]) ? $alias[$thr] : ['node' => $thr, 'title' => '','is_auth' => 0], ['pnode' => $two]);
        }
        $nodeModel  = new Node();
        foreach ($nodes as $key => &$node) {
            $tmp = Db::name('node')->where(['node'=>$node['node']])->find();
            if(!$tmp){
                $save["node"] = $node['node'];
                $nodeModel->save($save);
                $node['id'] = $nodeModel->id;
            }
            $node['is_auth'] = intval($node['is_auth']);
        }
        return $nodes;
    }

    /**
     * 驼峰转下划线规则
     * @param string $node
     * @return string
     */
    public static function parseNodeStr($node)
    {
        $tmp = [];
        foreach (explode('/', $node) as $name) {
            $tmp[] = strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
        return trim(join('/', $tmp), '/');
    }


    /**
     * 获取节点列表
     * @param string $dirPath 路径
     * @param array $nodes 额外数据
     * @return array
     */
    public static function getNodeTree($dirPath, $nodes = [])
    {
        $appNameSpace =  Config::get('app.app_namespace')?Config::get('app.app_namespace'):'app';
        foreach (self::scanDirFile($dirPath) as $filename) {
            $matches = [];
            if (!preg_match('|/(\w+)/controller/(\w+)|', str_replace(DIRECTORY_SEPARATOR, '/', $filename), $matches) || count($matches) !== 3) {
                continue;
            }
            $className = $appNameSpace . str_replace('/', '\\', $matches[0]);
            if (!class_exists($className)) {
                continue;
            }
            foreach (get_class_methods($className) as $funcName) {
                if (strpos($funcName, '_') !== 0 && $funcName !== 'initialize') {
                    $nodes[] = self::parseNodeStr("{$matches[1]}/{$matches[2]}") . '/' . strtolower($funcName);
                }
            }
        }
        return $nodes;
    }
    /**
     * 获取所有PHP文件
     * @param string $dirPath 目录
     * @param array $data 额外数据
     * @param string $ext 有文件后缀
     * @return array
     */
    private static function scanDirFile($dirPath, $data = [], $ext = 'php')
    {

        foreach (scandir($dirPath) as $dir) {
            if (strpos($dir, '.') === 0) {
                continue;
            }
            $tmpPath = realpath($dirPath . DIRECTORY_SEPARATOR . $dir);
            if (is_dir($tmpPath)) {
                $data = array_merge($data, self::scanDirFile($tmpPath));
            } elseif (pathinfo($tmpPath, 4) === $ext) {
                $data[] = $tmpPath;
            }
        }
        return $data;
    }

}