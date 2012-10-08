<?php

class m120917_075736_add_seen_by_assignee_flag_to_todo extends CDbMigration
{
	public function up()
	{
		$this->addColumn('td_todo', 'seen_by_assignee', 'boolean NOT NULL DEFAULT \'0\'');
		$this->update('td_todo', array('seen_by_assignee' => true));
	}

	public function down()
	{
		$this->dropColumn('td_todo', 'seen_by_assignee', 'boolean not null');
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
