<?php	
require_once 'core/init.php';

	if (Session::exsits('home')) {
		echo '<p>'.Session::flash('home').'</p>';
	}

	$user = new User();

	if($user->isLoggedIn()) {
?>
	<p>Hello <a href="profile.php?user=<?php echo $user->a()->username; ?>"><?php echo $user->a()->username; ?></a>!</p>

	<ul>

		<li>
			<a href="logout.php">Logout</a>
		</li>

		<li>
			<a href="update.php">Update Informations</a>
		</li>

		<li>
			<a href="changepassword.php">Change Password</a>
		</li>

	</ul>

<?php

	if ($user->hasPermission('admin')) {
		echo "You are admin";
	}

} else {
	echo "You need to <a href='login.php'>Login</a> or <a href='register.php'>Register</a>";
}