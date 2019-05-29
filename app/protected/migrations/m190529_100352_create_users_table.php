<?php

class m190529_100352_create_users_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('tbl_users', [
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'role' => 'string NOT NULL',
        ]);
	}

	public function down()
	{
		echo "m190529_100352_create_users_table does not support migration down.\n";
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
