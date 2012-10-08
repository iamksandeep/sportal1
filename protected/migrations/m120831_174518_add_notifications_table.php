<?php

class m120831_174518_add_notifications_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('notification', array(
			'id' => 'pk',
			'activity_id' => 'integer not null',
			'target_id' => 'integer not null',
			'ack' => 'boolean NOT NULL DEFAULT \'0\'',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('fk_notification_activity', 'notification', 'activity_id',
							'activity', 'id', 'CASCADE', 'CASCADE');

		$this->addForeignKey('fk_notification_target', 'notification', 'target_id',
							'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('fk_notification_activity', 'notification');
		$this->dropForeignKey('fk_notification_target', 'notification');
		$this->dropTable('notification');
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
