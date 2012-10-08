<?php

class m120817_074854_add_table_user extends CDbMigration
{
	public function up()
	{
		$this->createTable('user', array(
				'id' => 'pk',
				'name_first' => 'string not null',
				'name_last' => 'string not null',
				'email' => 'string not null',
				'password' => 'string not null',
			), 'ENGINE=InnoDB');
	}

	public function down()
	{
		$this->dropTable('user');
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