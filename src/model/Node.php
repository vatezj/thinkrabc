<?php
namespace Hualex\ThinkRabc\model;

use think\Model;
class Node extends Model{
    // TODO
    protected $name = 'node';
    protected $pk = 'id';
    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'node'        => 'string',
        'title'      => 'string',
        'is_auth'       => 'int',
        'create_time' => 'datetime'
    ];
}
