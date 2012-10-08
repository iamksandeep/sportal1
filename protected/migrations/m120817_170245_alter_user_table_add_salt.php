<?php

class m120817_170245_alter_user_table_add_salt extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'password_salt', 'string not null');
	}

	public function down()
	{
		$this->dropColumn('user', 'password_salt');
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