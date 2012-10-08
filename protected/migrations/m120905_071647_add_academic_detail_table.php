<?php

class m120905_071647_add_academic_detail_table extends CDbMigration
{
	public function up()
	{
	    $this->createTable( 'pr_academic', array(
	      'id' => 'pk',
	      'student_id' => 'integer NOT NULL',
	      'level' => 'integer NOT NULL',
	      'institution' => 'string NOT NULL',
	      'board_univ' => 'string NOT NULL',
	      'score' => 'string NOT NULL',
	      'year' => 'integer NOT NULL',
	    ), 'ENGINE=InnoDB' );

	    $this->addForeignKey( 'fk_pr_academic_student', 'pr_academic', 'student_id', 'user', 'id', 'CASCADE', 'CASCADE' );
	}

	public function down()
	{
	    $this->dropForeignKey( 'fk_pr_academic_student', 'pr_academic' );
	    $this->dropTable( 'pr_academic' );
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
