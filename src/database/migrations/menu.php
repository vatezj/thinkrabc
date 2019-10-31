<?php

use think\migration\Migrator;
use think\migration\db\Column;

class  Menu extends  Migrator
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
        $table = $this->table('auth',array('engine'=>'InnoDB','id' => false, 'primary_key' => ['id']));
        $table->addColumn('pid', 'integer',array('comment'=>'父id'))
            ->addColumn('status', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'状态(0:禁用,1:启用)'))
            ->addColumn('node_id', 'integer',array('comment'=>'节点id'))
            ->addColumn('title', 'string',array('comment'=>'名称'))
            ->addColumn('sort', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'图标'))
            ->addColumn('icon', 'string',array('comment'=>'图标'))
            ->addColumn('url', 'string',array('comment'=>'链接'))
            ->addColumn('params', 'string',array('comment'=>'参数key'))
            ->addColumn('values', 'string',array('comment'=>'默认参数值'))
            ->addColumn('create_time', 'datetime')
            ->addColumn('update_time', 'datetime')
            ->addColumn('delete_time', 'datetime')
            ->create();
    }

}