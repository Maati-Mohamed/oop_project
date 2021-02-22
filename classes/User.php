<?php 
	class User {

		private $_db,
				$_data,
				$_sessionName,
				$_cookieName,
				$_isLoggedIn;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();

			$this->_sessionName = Config::get('session/session_name');
			$this->_cookieName = Config::get('remeber/cookie_name');

			if (!$user) {
				if (Session::exsits($this->_sessionName)) {
					$user = Session::get($this->_sessionName);

					if($this->find($user)) {
						$this->_isLoggedIn = true;
					} else {
						// Process logout 
					}
				}
			} else {

			    $this->find($user);
			}
		}

		public function update($fields = array(),$id = null) {
			if (!$id && $this->isLoggedIn()) {
				$id = $this->a()->id;
			}
			if (!$this->_db->update('users',$id,$fields)) {
				throw new Exception("There was problem updating");
				
			}
		}


		public function create($fields = array()) {	
			if(!$this->_db->insert('users',$fields)) {
				throw new Exception('There was a problem creating an account');
			} 
		}

		public function find($user = null) {
			if ($user) {

				$field = (is_numeric($user)) ? 'id' : 'username';
				$data  = $this->_db->get('users',array($field,'=',$user)); 

				if ($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}

		public function login($username = null,$password = null,$remeber = false) {
			if (!$username && !$password && $this->exsits()) {
				Session::put($this->_sessionName,$this->a()->id);
			} else {
					$user = $this->find($username);
				if ($user) {
					
					if ($this->a()->password === Hash::make($password)) {
					
						Session::put($this->_sessionName,$this->a()->id);

						if ($remeber) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session',array('users_id','=',$this->a()->id));
						if (!$hashCheck->count()) {
							$this->_db->insert('users_session',array(
								'users_id' => $this->a()->id,
								'hash' => $hash
							));

						} else {
							$hash = $hashCheck->first()->hash;
						}

						Cookie::put($this->_cookieName,$hash,Config::get('remeber/cookie_expiry'));

					    }
					    return true;
					}

				}
			}
			return false;
		}

		public function hasPermission($key) {
			$group = $this->_db->get('groups',array('id','=',$this->a()->group));
			if ($group->count()) {
				$permissions = json_decode($group->first()->permissions,true);
				if (isset($permissions[$key])) {
				//if ($permissions[$key] == true) {
					return true;
				} 
			}
			return false;
		}

		public function exists() {
			return (!empty($this->_data)) ? true : false;
		}

		public function logout() {

			$this->_db->delete('users_session',array('users_id','=',$this->a()->id));
			Session::delete($this->_sessionName);
			Cookie::delete($this->_cookieName);

		}

		public function a() {
			return $this->_data;
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}

	}
