<?php

class m120821_051406_add_activity_table extends CDbMigration
{
	public function up() {
	    $this->createTable( 'activity', array(
	      'id' => 'pk',
	      'student_id' => 'integer NOT NULL',
	      'application_id' => 'integer',
	      'application_task_id' => 'integer',
	      'comment' => 'text NOT NULL',
	      'log' => 'boolean NOT NULL DEFAULT \'0\'',
	      'author_id' => 'integer NOT NULL',
	      'time' => 'datetime NOT NULL',
	    ), 'ENGINE=InnoDB' );

	    $this->addForeignKey( 'fk_activity_student', 'activity', 'student_id',
	                              'user', 'id', 'CASCADE', 'CASCADE' );
	    $this->addForeignKey( 'fk_activity_application', 'activity', 'application_id',
	                              'at_application', 'id', 'CASCADE', 'CASCADE' );
	    $this->addForeignKey( 'fk_activity_application_task', 'activity', 'application_task_id',
	                              'at_application_task', 'id', 'CASCADE', 'CASCADE' );
	    $this->addForeignKey( 'fk_activity_author', 'activity', 'author_id',
	                              'user', 'id', 'CASCADE', 'CASCADE' );
	}

	public function down() {
	    $this->dropForeignKey( 'fk_activity_author', 'activity' );
	    $this->dropForeignKey( 'fk_activity_application_task', 'activity' );
	    $this->dropForeignKey( 'fk_activity_application', 'activity' );
	    $this->dropForeignKey( 'fk_activity_student', 'activity' );
	    $this->dropTable( 'activity' );
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