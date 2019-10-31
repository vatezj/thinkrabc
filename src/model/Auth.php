<?php
namespace Hualex\ThinkRabc\model;

use think\Model;
use Hualex\ThinkRabc\model\Node;
use Hualex\ThinkRabc\model\AuthNode;

class Auth extends Model{
    // TODO
    protected $name = 'auth';
    protected $pk = 'auth_id';
    // 设置字段信息
    protected $schema = [
        'auth_id'          => 'int',
        'name'        => 'string',
        'status'      => 'int',
        'is_default'      => 'int',
        'desc'       => 'string',
        'create_time' => 'datetime',
        'update_time' => 'datetime'
    ];
    public function roles()
    {
        return $this->belongsToMany(Node::class, AuthNode::class);
    }
}
