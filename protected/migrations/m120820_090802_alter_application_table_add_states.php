<?php

class m120820_090802_alter_application_table_add_states extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('at_application', 'active');
		$this->dropColumn('at_application', 'complete');
		$this->addColumn('at_application', 'state', 'INTEGER NOT NULL DEFAULT \'0\'');
	}

	public function down()
	{
		$this->dropColumn('at_application', 'state');
		$this->addColumn('at_application', 'active', 'boolean NOT NULL DEFAULT \'0\'');
		$this->addColumn('at_application', 'complete', 'boolean NOT NULL DEFAULT \'0\'');
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