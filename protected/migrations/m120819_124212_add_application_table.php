<?php

class m120819_124212_add_application_table extends CDbMigration
{
	public function up()
	{
    $this->createTable( 'at_application', array(
      'id' => 'pk',
      'student_id' => 'integer NOT NULL',
      'university' => 'string NOT NULL',
      'course' => 'string NOT NULL',
      'deadline' => 'datetime',
      'active' => 'boolean NOT NULL DEFAULT \'0\'',
      'complete' => 'boolean NOT NULL DEFAULT \'0\'',
    ), 'ENGINE=InnoDB' );

    $this->addForeignKey( 'fk_application_student', 'at_application', 'student_id', 'user', 'id', 'RESTRICT', 'CASCADE' );
	}

	public function down()
	{
    $this->dropForeignKey( 'fk_application_student', 'at_application' );
    $this->dropTable( 'at_application' );
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