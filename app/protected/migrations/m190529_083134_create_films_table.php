<?php

class m190529_083134_create_films_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('tbl_films', [
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'descriptiopn' => 'text',
            'user_id' => 'integer NOT NULL',
        ]);
	}

	public function down()
	{
		echo "m190529_083134_create_films_table does not support migration down.\n";
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
