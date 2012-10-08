<?php

class m120910_060903_add_university_type_field_to_application extends CDbMigration
{
	public function up()
	{
		$this->addColumn('at_application', 'type', 'integer not null DEFAULT \'1\'');
		$this->update('at_application', array('type' => 1));
	}

	public function down()
	{
		$this->dropColumn('at_application', 'type');
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
