<?php
namespace Hualex\ThinkRabc\model;

use think\Model;
use think\model\Pivot;
class AuthNode extends Pivot{
    // TODO
    protected $name = 'auth_node';
    protected $pk = 'id';
    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'auth_id'        => 'int',
        'node_id'      => 'int',
    ];

}
