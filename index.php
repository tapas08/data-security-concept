<?php
	require_once 'Core/init.php';

	$db = DB::getInstance();

	if (isset($_POST['username']) && !empty($_POST['username']) && 
		isset($_POST['password']) && !empty($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if ($db->exists($username)){
			
			$entry = $db->getEntry($username);	//will return where the data is stored.
			$user_data = $db->getData($entry, $username);
			if ((int)$entry == 0){
				
				if (hash('sha256', $password) != $user_data->password){
					echo "Password is incorrect!";
					return 1;
				}else{
					echo "YOu are stored in database server!";
				}
			}elseif ((int)$entry == 1) {
				if (hash('sha256', $password) != $user_data['password']){
					echo "Password is incorrect!";
					return 1;
				}else{
					echo "YOu are stored in filesystem on the server!";
				}
			}else{
				echo "nah!";
			}
		}else{
			echo "You need to register!";
		}
	}
	

?>
<br />
<a href="register.php">Register</a>

<h3>Login</h3>

<form method="POST" action="">
	<input type="text" name="username" id="username" placeholder="username" /><br /><br />
	<input type="password" name="password" id="password" placeholder="password" /><br /><br />
	<input type="submit" value="Submit" />
</form>