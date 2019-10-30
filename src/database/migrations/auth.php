<?php

use think\migration\Migrator;
use think\migration\db\Column;

class  Auth extends  Migrator
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
        $table = $this->table('auth',array('engine'=>'InnoDB','id' => false, 'primary_key' => ['auth_id']));
        $table->addColumn('name', 'string',array('limit'  =>  15,'default'=>'','comment'=>'权限名称'))
            ->addColumn('status', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'状态(1:禁用,2:启用)'))
            ->addColumn('created_time', 'datetime')
            ->addColumn('update_time', 'datetime')
            ->addColumn('delete_time', 'datetime')
            ->create();
    }

}