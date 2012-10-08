<?php

class m120823_085550_add_todo_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('td_todo', array(
			'id' => 'pk',
			'title' => 'string NOT NULL',
			'description' => 'text',
			'assignee_id' => 'integer NOT NULL',
			'assigner_id' => 'integer NOT NULL',
			'student_id' => 'integer NOT NULL',
			'application_id' => 'integer',
			'application_task_id' => 'integer',
			'initiate_time' => 'datetime NOT NULL',
			'deadline' => 'datetime',
			'state' => 'integer NOT NULL DEFAULT \'0\'',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('fk_todo_assignee', 'td_todo', 'assignee_id', 'user', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_todo_assigner', 'td_todo', 'assigner_id', 'user', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_todo_student', 'td_todo', 'student_id', 'user', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_todo_application', 'td_todo', 'application_id', 'at_application', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_todo_application_task', 'td_todo', 'application_task_id', 'at_application_task', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('fk_todo_assignee', 'td_todo');
		$this->dropForeignKey('fk_todo_assigner', 'td_todo');
		$this->dropForeignKey('fk_todo_student', 'td_todo');
		$this->dropForeignKey('fk_todo_application', 'td_todo');
		$this->dropForeignKey('fk_todo_application_task', 'td_todo');
		$this->dropTable('td_todo');
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