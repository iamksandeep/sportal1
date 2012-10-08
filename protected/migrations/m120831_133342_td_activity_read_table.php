<?php

class m120831_133342_td_activity_read_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('td_activity_read', array(
			'todo_activity_id' => 'integer not null',
			'user_id' => 'integer not null',
			'PRIMARY KEY(todo_activity_id, user_id)',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('fk_td_activity_read_activity', 'td_activity_read', 'todo_activity_id',
							'td_activity', 'id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('fk_td_activity_read_user', 'td_activity_read', 'user_id',
							'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('fk_td_activity_read_user', 'td_activity_read');
		$this->dropForeignKey('fk_td_activity_read_activity', 'td_activity_read');
		$this->dropTable('td_activity_read');
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
