<?php

class m120905_144727_add_admin_user extends CDbMigration
{
	public function up()
	{
		$this->insert('user', array(
			'name_first' => 'Root',
			'name_last' => '.',
			'email' => 'root',
			'password' => 'ee784c2d7a473fa45ab88e82247fc317ddec15113e970d73d566a20a4aa6c908536cd6eda936d5e87a03a5a2d1c4551bbb1b0ec177296313565cfd24eff1961c',  // admin
			'password_salt' => 'e2b2ec58a2e892ef1b74aee6a5fb04ae',
			'type' => 0,
		));
	}

	public function down()
	{
		$this->delete('user', 'email = :email', array(':email' => 'admin'));
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
