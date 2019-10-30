<?php

use think\migration\Migrator;
use think\migration\db\Column;

class  Node extends  Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     * createTable
     * renameTable
     * addColumn
     * renameColumn
     * addIndex
     * addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    public  function  change()
    {
        // create the table
        $table = $this->table('node',array('engine'=>'InnoDB','id' => false, 'primary_key' => ['node_id']));
        $table->addColumn('node', 'string',array('limit'  =>  100,'default'=>'','comment'=>'节点代码'))
            ->addColumn('title', 'string',array('limit'  =>  200,'default'=>'','comment'=>'节点标题'))
            ->addColumn('is_auth', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'是否启动RBAC权限控制状态(0:禁用,1:启用)'))
            ->addColumn('created_time', 'datetime')
            ->addColumn('update_time', 'datetime')
            ->addColumn('delete_time', 'datetime')
            ->create();
    }

}