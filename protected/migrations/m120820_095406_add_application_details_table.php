<?php

class m120820_095406_add_application_details_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('at_application_detail', array(
			'id' => 'pk',
			'application_id' => 'integer not null',
			'title' => 'string not null',
			'content' => 'text not null',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('at_app_detail_application', 'at_application_detail', 'application_id', 'at_application',
							'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('at_app_detail_application', 'at_application_detail');
		$this->dropTable('at_application_detail');
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