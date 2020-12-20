<?php
	
	require_once 'core/init.php';

	$user = DB::getInstance()->query("SELECT * FROM users", ['name_ar', '=', 'احذية']);

	echo"<pre>";
		print_r($user);
	echo"</pre>";
