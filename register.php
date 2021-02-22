<?php 
require_once 'core/init.php';

	if (Input::exists()) {
		if (Token::check(Input::get('token'))) {
		
			$validate = new Validate();
			$validation = $validate->check($_POST,array(
				'username' => array(
					'require' => true,
					'min' 	  => 2,
					'max'	  => 20,
					'unique'  => 'users'
				),
				'password' => array(
					'require' => true,
					'min' 	  => 2
				),

				'password_again' => array(
					'require' => true,
					'matches' 	  => 'password'
				),
				'name' => array(
					'require' => true,
					'min' 	  => 2,
					'max'	  => 50
				)

			));

			if ($validation->passed()) {

				$user =  new User();

			    $salt = 'mohamed';
			

				try{
					$user->create(array(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('password')),
						'salt' => $salt,
						'name' => Input::get('name'),
						'joined' => date('Y-m-d H:i:s'),
						'group' => 1

					));

				Session::flash('home','You have been registered and can now login');
				
				Redirect::to('index.php');

				} catch(Exception $e) {
					die($e->getMessage());
				}

			} else {
				foreach($validation->errors() as $error) {
					echo $error."<br>";
				}
			}
		}
	}

	?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">Choose a passwoed</label>
		<input type="password" name="password" id="password">
	</div>


	<div class="field">
		<label for="password_again">Inter your password again </label>
		<input type="password" name="password_again" id="password_again">
	</div>


	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

	<input type="submit" value="Register">

</form>