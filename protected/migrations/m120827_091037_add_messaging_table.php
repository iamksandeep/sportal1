<?php

class m120827_091037_add_messaging_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('msg_msg', array(
			'id' => 'pk',
			'conversation_id' => 'integer not null',
			'author_id' => 'integer not null',
			'content' => 'text not null',
			'send_time' => 'datetime not null'
		), 'ENGINE=InnoDB');

		$this->addForeignKey('msg_msg_conversation', 'msg_msg', 'conversation_id',
							'msg_conv', 'id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('msg_msg_author', 'msg_msg', 'author_id',
							'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('msg_msg_author', 'msg_msg');
		$this->dropForeignKey('msg_msg_conversation', 'msg_msg');
		$this->dropTable('msg_msg');
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
