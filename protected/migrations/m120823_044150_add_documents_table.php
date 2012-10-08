<?php

class m120823_044150_add_documents_table extends CDbMigration
{
	public function up()
	{
	    $this->createTable('document', array(
	      'id' => 'pk',
	      'student_id' => 'integer NOT NULL',
	      'application_id' => 'integer',
	      'title' => 'string NOT NULL',
	      'description' => 'text',
	      'type' => 'integer NOT NULL',
	      'filename' => 'string NOT NULL',
	      'extension' => 'string',
	      'upload_time' => 'datetime NOT NULL',
	      'uploader_id' => 'integer NOT NULL',
	    ), 'ENGINE=InnoDB');

	    $this->addForeignKey( 'fk_document_application', 'document', 'student_id',
	                          'user', 'id', 'RESTRICT', 'CASCADE' );

	    $this->addForeignKey( 'fk_document_student', 'document', 'application_id',
	                          'at_application', 'id', 'RESTRICT', 'CASCADE' );

	    $this->addForeignKey( 'fk_document_uploader', 'document', 'uploader_id',
	                          'user', 'id', 'RESTRICT', 'CASCADE' );
	}

	public function down()
	{
	    $this->dropForeignKey( 'fk_document_uploader', 'document');
	    $this->dropForeignKey( 'fk_document_application', 'document');
	    $this->dropForeignKey( 'fk_document_student', 'document');

	    $this->dropTable( 'document' );
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