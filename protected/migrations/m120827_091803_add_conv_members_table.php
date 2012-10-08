<?php

class m120827_091803_add_conv_members_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('msg_conv_member', array(
			'conv_id' => 'integer not null',
			'user_id' => 'integer not null',
			'PRIMARY KEY(conv_id, user_id)',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('msg_conv_member_conv', 'msg_conv_member', 'conv_id',
							'msg_conv', 'id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('msg_conv_member_user', 'msg_conv_member', 'user_id',
							'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('msg_conv_member_conv', 'msg_conv_member');
		$this->dropForeignKey('msg_conv_member_user', 'msg_conv_member');
		$this->dropTable('msg_conv_member');
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
