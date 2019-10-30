<?php

use think\migration\Migrator;
use think\migration\db\Column;

class  AuthNode extends  Migrator
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
        $table = $this->table('auth_node',array('engine'=>'InnoDB'));
        $table->addColumn('auth_id', 'integer',array('limit'  =>  11,'default'=>'','comment'=>'角色ID'))
            ->addColumn('node_id', 'integer',array('limit'  =>  11,'default'=>'','comment'=>'节点id'))
            ->addColumn('created_time', 'datetime')
            ->addColumn('update_time', 'datetime')
            ->addColumn('delete_time', 'datetime')
            ->create();
    }

}