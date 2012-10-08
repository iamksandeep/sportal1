<?php

class m120912_071532_add_complete_time_to_todo extends CDbMigration
{
	public function up()
	{
		$this->addColumn('td_todo', 'complete_time', 'datetime');
	}

	public function down()
	{
		$this->dropColumn('td_todo', 'complete_time');
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
