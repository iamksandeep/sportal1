<?php

class m120830_052745_add_todo_activity_table extends CDbMigration
{
	public function up() {
	    $this->createTable( 'td_activity', array(
	      'id' => 'pk',
	      'todo_id' => 'integer NOT NULL',
	      'comment' => 'text NOT NULL',
	      'log' => 'boolean NOT NULL DEFAULT \'0\'',
	      'author_id' => 'integer NOT NULL',
	      'time' => 'datetime NOT NULL',
	    ), 'ENGINE=InnoDB' );

	    $this->addForeignKey( 'fk_td_activity_todo', 'td_activity', 'todo_id',
	                              'td_todo', 'id', 'CASCADE', 'CASCADE' );
	    $this->addForeignKey( 'fk_td_activity_author', 'td_activity', 'author_id',
	                              'user', 'id', 'CASCADE', 'CASCADE' );
	}

	public function down() {
	    $this->dropForeignKey( 'fk_td_activity_author', 'td_activity' );
	    $this->dropForeignKey( 'fk_td_activity_todo', 'td_activity' );
	    $this->dropTable( 'td_activity' );
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
