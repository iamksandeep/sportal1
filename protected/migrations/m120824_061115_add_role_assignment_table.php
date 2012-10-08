<?php

class m120824_061115_add_role_assignment_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('role_assignment', array(
				'id' => 'pk',
				'student_id' => 'integer not null',
				'user_id' => 'integer not null',
				'role' => 'integer not null',
			), 'ENGINE=InnoDB');

		$this->addForeignKey('fk_role_assignment_student', 'role_assignment', 'student_id',
													'user', 'id', 'CASCADE', 'CASCADE' );

		$this->addForeignKey('fk_role_assignment_user', 'role_assignment', 'user_id',
													'user', 'id', 'CASCADE', 'CASCADE' );
	}

	public function down()
	{
		$this->dropForeignKey('fk_role_assignment_student', 'role_assignment');
		$this->dropForeignKey('fk_role_assignment_user', 'role_assignment');
		$this->dropTable('role_assignment');
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