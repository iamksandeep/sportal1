<?php

class m120818_155421_alter_user_table_add_disabled_flag extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'disabled', 'boolean not null DEFAULT \'0\'');
	}

	public function down()
	{
		$this->dropColumn('user', 'disabled');
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