<?php

class m120906_043314_add_univ_credentials_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('at_university_credential', array(
			'id' => 'pk',
			'application_id' => 'integer not null',
			'details' => 'string not null',
			'url' => 'text not null',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('fk_university_credential_application', 'at_university_credential', 'application_id',
								'at_application', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('fk_university_credential_application', 'at_university_credential');
		$this->dropTable('at_university_credential');
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
