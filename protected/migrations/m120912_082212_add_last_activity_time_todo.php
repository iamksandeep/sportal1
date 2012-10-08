<?php

class m120912_082212_add_last_activity_time_todo extends CDbMigration
{
	public function up()
	{
		$this->addColumn('td_todo', 'last_activity_time', 'datetime');
	}

	public function down()
	{
		$this->dropColumn('td_todo', 'last_activity_time');
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
