<?php

class m190529_100029_create_comments_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('tbl_comments', [
            'id' => 'pk',
            'content' => 'string NOT NULL',
            'user_id' => 'integer',
            'film_id' => 'integer',
        ]);
	}

	public function down()
	{
		echo "m190529_100029_create_comments_table does not support migration down.\n";
		return false;
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
