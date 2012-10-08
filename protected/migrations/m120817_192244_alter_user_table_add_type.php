<?php

class m120817_192244_alter_user_table_add_type extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'type', 'INTEGER NOT NULL DEFAULT \'0\'');
	}

	public function down()
	{
		$this->dropColumn('user', 'type');
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