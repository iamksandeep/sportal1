<?php

class m120827_091648_add_message_read_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('msg_read', array(
			'msg_id' => 'integer not null',
			'user_id' => 'integer not null',
			'PRIMARY KEY(msg_id, user_id)',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('msg_read_msg', 'msg_read', 'msg_id',
							'msg_msg', 'id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('msg_read_user', 'msg_read', 'user_id',
							'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('msg_read_msg', 'msg_read');
		$this->dropForeignKey('msg_read_user', 'msg_read');
		$this->dropTable('msg_read');
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
