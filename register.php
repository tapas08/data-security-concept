<?php
	require_once 'Core/init.php';

	$db = DB::getInstance();

	if (isset($_POST['submit'])){
		$username = $_POST['username'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_again = $_POST['password_again'];

		if (!empty($username) && !empty($name) && !empty($email) && !empty($password) && !empty($password_again)){
			if ($db->exists($username)){
				echo "the username is already in use!<br />YOu might want to <a href='index.php'>Login</a>";
				die();
			}else{
				if ($password === $password_again){
					$db->select_storage(array(
						'username' => $username,
						'full_name' => $name,
						'email' => $email,
						'password' => hash('sha256', $password),
						'unique_id' => uniqid(),
						'date' => date('H:i:s j-M-Y')
					));	

					echo "You can now <a href='index.php'>login</a><br/>";
				}
				
			}
		}else{
			echo "Something is wrong!";
		}
	
	}

?>

<a href="index.php">Back</a><br><br>
<form action="register.php" method="post">
	<input type="text" name="username" id="username" placeholder="username" /><br /><br />
	<input type="text" name="name" id="name" placeholder="name" /><br /><br />
	<input type="email" name="email" id="email" placeholder="email id" /><br /><br />
	<input type="password" name="password" id="password" placeholder="password" /><br /><br />
	<input type="password" name="password_again" id="password_again" placeholder="password again" /><br /><br />
	<input type="submit" name="submit" id="submit" value="Submit" />
</form>