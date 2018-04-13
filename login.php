<?php 

session_start();

//CHECK TO SEE IF THEY ARE A USER

if(isset($_POST['submit-login'])){
	
	$usernameInput = $_POST['input-username'];
	$passwordInput = $_POST['input-password'];
	$users = simplexml_load_file("users.xml");
	$user = $users->xpath('//*[username="'.$usernameInput.'"]')[0];
	$usernameStored = $user->username;
	$userpassStored = $user->password;

	if($userpassStored == $passwordInput && $usernameStored == $usernameInput){
		echo "<hr/>";

		$_SESSION['username_sess'] = $usernameInput.'';
		$_SESSION['id'] = $user->id.'';
		$_SESSION['type'] = $user->type.'';
		//echo $usernameInput;
		//echo "hello";
		if(isset($_SESSION['type']) && $_SESSION['type'] == 'staff'){
			header('location: adminIndex.php');
			} else
			 if(isset($_SESSION['type']) && $_SESSION['type'] == 'customer'){
					header('location: userIndex.php');
				}
				else{
				header('location: login.php');
				}
		}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<h1>Welcome to Support Ticket System</h1>
	<h2>Please sign in</h2>
	<form action="login.php" method="POST">
		<div>
			<label>Username:</label>
			<input type="text" name="input-username">
		</div>
		<div>
			<label>Password:</label>
			<input type="text" name="input-password">
		</div>
		<div>
			<input type="submit" name="submit-login">
		</div>
	</form>
</body>
</html>