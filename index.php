<?php
	
	require_once 'core/init.php';

	$user = DB::getInstance();

	// $test = $user->query("SELECT * FROM users");

	echo"<pre>";
		print_r($user->_pdo);
	echo"</pre>";









	echo "test";
