<?php 
class Session {
	public static function exsits($name) {
		return (isset($_SESSION[$name])) ? true : false;
	} 

	public static function put ($name,$value){
		return $_SESSION[$name] = $value;
	}

	public static function get($name) {
		return $_SESSION[$name];
	}

	public static function delete($name) {
		if (self::exsits($name)) {
			unset($_SESSION[$name]);
			//session_destroy($_SESSION[$name]);
			return true;
		}
	} 

	public static function flash($name,$string = '') {
		if(self::exsits($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;
		} else {
			Self::put($name,$string);
		}
	} 
}
