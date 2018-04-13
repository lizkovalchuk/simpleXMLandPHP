<?php

session_start();

if(!isset($_SESSION['type'])){
	header("Location: login.php");
}

	if(isset($_POST['logout'])) {
		unset($_SESSION['username_sess']);
		unset($_SESSION['id']);
		unset($_SESSION['type']);
		header("Location: login.php");
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>LOGOUT</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

</body>
</html>

<form method="post">
	<input type="submit" name="logout" value="LOG OUT">
</form>