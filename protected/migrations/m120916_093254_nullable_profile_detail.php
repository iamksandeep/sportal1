<?php

class m120916_093254_nullable_profile_detail extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('pr_detail', 'content', 'text');
	}

	public function down()
	{
		$this->alterColumn('pr_detail', 'content', 'text NOT NULL');
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
