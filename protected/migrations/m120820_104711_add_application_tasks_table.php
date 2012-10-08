<?php

class m120820_104711_add_application_tasks_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('at_application_task', array(
		  'id' => 'pk',
		  'application_id' => 'integer NOT NULL',
		  'title' => 'string NOT NULL',
		  'description' => 'text',
		  'state' => 'integer NOT NULL DEFAULT \'0\'',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('fk_application_task_application', 'at_application_task', 'application_id',
		                      'at_application', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
    	$this->dropForeignKey('fk_application_task_application', 'at_application_task');
    	$this->dropTable('at_application_task');
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