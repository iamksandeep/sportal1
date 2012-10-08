<?php

class m120916_095036_nullable_credentials_detail extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('at_university_credential', 'details', 'string');
		$this->alterColumn('at_university_credential', 'url', 'text');
	}

	public function down()
	{
		$this->alterColumn('at_university_credential', 'details', 'string NOT NULL');
		$this->alterColumn('at_university_credential', 'url', 'text NOT NULL');
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
