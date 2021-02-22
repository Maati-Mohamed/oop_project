<?php 
	session_start();

	$GLOBALS['Config'] = array(

		'mysql'   => array(
			'host' 			=> '127.0.0.1',
			'username'		=> 'root',
			'password' 		=> '',
			'db'			=> 'lr'
		),

		'remeber' => array(
			'cookie_name' 	=> 'hash',
			'cookie_expiry'	=> '604800'
		),

		'session' => array(
			'session_name'  => 'user',
			'token_name' => 'token'
		)

	);
		spl_autoload_register(function($class){
			require_once 'classes/'.$class.'.php';
		});

			require_once 'functions/sanitize.php';

if (Cookie::exsits(Config::get('remeber/cookie_name')) && !Session::exsits(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remeber/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session',array('hash','=',$hash));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->users_id);
		$user->login();
	}
}

			