<?php

class m120831_054743_add_todo_docs_table extends CDbMigration
{
	public function up()
	{
	    $this->createTable('td_document', array(
	      'id' => 'pk',
	      'todo_id' => 'integer NOT NULL',
	      'title' => 'string NOT NULL',
	      'description' => 'text',
	      'filename' => 'string NOT NULL',
	      'extension' => 'string',
	      'upload_time' => 'datetime NOT NULL',
	      'uploader_id' => 'integer NOT NULL',
	    ), 'ENGINE=InnoDB');

	    $this->addForeignKey( 'fk_todo_document_todo', 'td_document', 'todo_id',
	                          'td_todo', 'id', 'CASCADE', 'CASCADE' );

	    $this->addForeignKey( 'fk_todo_document_uploader', 'td_document', 'uploader_id',
	                          'user', 'id', 'CASCADE', 'CASCADE' );
	}

	public function down()
	{
	    $this->dropForeignKey( 'fk_todo_document_todo', 'td_document');
	    $this->dropForeignKey( 'fk_todo_document_uploader', 'td_document');
	    $this->dropTable( 'td_document' );
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
