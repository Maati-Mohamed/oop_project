<?php 
	class Hash {

		public static function make($string) {
			return hash('sha256',$string);
		}


		/*public static function make($string,$salt = '') {
			return hash('sha256',$string.$salt);
		}

		public static function salt($length) {
			return mcrypt_create_iv($length);
			return sha1($length);
		} */

		public static function unique() {
			return self::make(uniqid());
		}
	}
