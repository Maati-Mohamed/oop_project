<?php 
	require_once 'core/init.php';

	if (Input::exists()) {
		if (Token::check(Input::get('token'))) {

			$validate = new Validate();
			$validation = $validate->check($_POST,array(
				'username' => array('require' => true),
				'password' => array('require' => true)
			));

			if ($validation->passed()) {
				//Now  User lo in 
				$user = new User(); 
				$remeber = (Input::get('remeber') === 'on') ? true : false;
				$login = $user->login(Input::get('username'),Input::get('password'),$remeber);

				if ($login) {
					Redirect::to('index.php');
				} else {
					echo 'Sorry, login faild!';
				}
			} else {
				foreach ($validation->errors() as $error) {
					echo $error.'<br>';
				}
			}
		}
	}

?>
<form action="" method="post">

	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off">
	</div> 

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" autocomplete="newpassword">
	</div>

	<div class="field">
		<label for="remeber">Remeber me
			<input type="checkbox" name="remeber" id="remeber"> 
		</label>
	</div>

		<input type="hidden" name="token" value="<?php echo Token::generate()?>">
		<input type="submit" value="Log in">

</form>