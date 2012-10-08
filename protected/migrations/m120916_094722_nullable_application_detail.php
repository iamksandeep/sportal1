<?php

class m120916_094722_nullable_application_detail extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('at_application_detail', 'content', 'text');
	}

	public function down()
	{
		$this->alterColumn('at_application_detail', 'content', 'text NOT NULL');
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
