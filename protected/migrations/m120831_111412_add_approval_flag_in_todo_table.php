<?php

class m120831_111412_add_approval_flag_in_todo_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('td_todo', 'approved', 'boolean NOT NULL DEFAULT \'0\'');
	}

	public function down()
	{
		$this->dropColumn('td_todo', 'approved');
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
