<?php

class m120905_092611_add_profile_details_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('pr_detail', array(
			'id' => 'pk',
			'student_id' => 'integer not null',
			'category' => 'integer not null',
			'title' => 'string not null',
			'content' => 'text',
		), 'ENGINE=InnoDB');

		$this->addForeignKey('fk_pr_detail_student', 'pr_detail', 'student_id', 'user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('fk_pr_detail_student', 'pr_detail');
		$this->dropTable('pr_detail');
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
