<?php

class m120901_064524_rbac_tables extends CDbMigration
{
    public function up()
    {
        // AuthItem
        $this->createTable( 'AuthItem', array(
            'name' => 'varchar(64) not null',
            'type' => 'integer not null',
            'description' => 'text',
            'bizrule' => 'text',
            'data' => 'text',
            'PRIMARY KEY (name)',
        ), 'ENGINE=InnoDB' );

        // AuthItemChild
        $this->createTable( 'AuthItemChild', array(
            'parent' => 'varchar(64) not null',
            'child' => 'varchar(64) not null',
            'PRIMARY KEY (parent, child)',
        ), 'ENGINE=InnoDB' );
        $this->addForeignKey( 'fk_AuthItemChild_parent', 'AuthItemChild', 'parent',
                                                    'AuthItem', 'name', 'CASCADE', 'CASCADE' );
        $this->addForeignKey( 'fk_AuthItemChild_child', 'AuthItemChild', 'child',
                                                    'AuthItem', 'name', 'CASCADE', 'CASCADE' );

        // AuthAssignment
        $this->createTable( 'AuthAssignment', array(
            'itemname' => 'varchar(64) not null',
            'userid' => 'string not null',
            'bizrule' => 'text',
            'data' => 'text',
            'PRIMARY KEY (itemname, userid)',
        ), 'ENGINE=InnoDB' );
        $this->addForeignKey( 'fk_AuthAssignment_itemname', 'AuthAssignment', 'itemname',
                                                    'AuthItem', 'name', 'CASCADE', 'CASCADE' );

    }

    public function down()
    {
        // AuthAssignment
        $this->dropForeignKey( 'fk_AuthAssignment_itemname', 'AuthAssignment' );
        $this->truncateTable( 'AuthAssignment' );
        $this->dropTable( 'AuthAssignment' );

        // AuthItemChild
        $this->dropForeignKey( 'fk_AuthItemChild_parent', 'AuthItemChild' );
        $this->dropForeignKey( 'fk_AuthItemChild_child', 'AuthItemChild' );
        $this->truncateTable( 'AuthItemChild' );
        $this->dropTable( 'AuthItemChild' );

        // AuthItem
        $this->truncateTable( 'AuthItem' );
        $this->dropTable( 'AuthItem' );
    }

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
