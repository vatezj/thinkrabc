<?php
namespace Hualex\ThinkRabc\model;

use think\Model;
use Hualex\ThinkRabc\model\Node;
use Hualex\ThinkRabc\model\AuthNode;

class Menu extends Model{
    // TODO
    protected $name = 'menu';
    protected $pk = 'id';
    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'pid'        => 'int',
        'node_id'      => 'int',
        'status'      => 'int',
        'sort'      => 'int',
        'title'      => 'string',
        'icon'      => 'string',
        'desc'       => 'string',
        'url'       => 'string',
        'params'       => 'string',
        'values'       => 'string',
        'url'       => 'string',
        'create_time' => 'datetime',
        'update_time' => 'datetime'
    ];

}
