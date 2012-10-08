<?php

class m120827_085142_add_conversation_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('msg_conv', array(
			'id' => 'pk',
			'subject' => 'string not null',
			'student_id' => 'integer not null',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('msg_conv_student', 'msg_conv', 'student_id', 'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('msg_conv_student', 'msg_conv');
		$this->dropTable('msg_conv');
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
