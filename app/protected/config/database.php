<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

	'connectionString' => 'mysql:host=mariadb;dbname=rtraid',
	//'emulatePrepare' => true,
	'username' => 'rtraid',
	'password' => 'rtraid',
	'charset' => 'utf8',

);
