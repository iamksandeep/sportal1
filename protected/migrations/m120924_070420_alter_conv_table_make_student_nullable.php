<?php

class m120924_070420_alter_conv_table_make_student_nullable extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('msg_conv', 'student_id', 'integer');
	}

	public function down()
	{
		$this->alterColumn('msg_conv', 'student_id', 'integer NOT NULL');
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
