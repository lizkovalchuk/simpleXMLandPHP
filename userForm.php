<?php

session_start();

if(!isset($_SESSION['type'])){
	header("Location: login.php");
}

$tickets = '';

if(file_exists("tickets.xml")){
	$tickets = simplexml_load_file("tickets.xml");

	if(isset($_POST['btn-submit'])){

//======= TAKE USER INPUT ==============//

		$date = $_POST['input-date'];
		$category = $_POST['category'];
		$description = $_POST['input-desc'];
		$message = $_POST['input-message'];

//======= CREATE ELEMEMTS ==============//

		$num_tickets = count($tickets) + 1;

			$ticket = $tickets->addChild("ticket");
			$ticket->addChild("id", $num_tickets);
			$ticket->addChild("status", "Open");
			$ticket->addChild("date", $date);
			$ticket->addChild("category", $category);
			$ticket->addChild("description", $description);
			$ticket->addChild("message", $message);
			$ticket->addChild("customerID", $_SESSION['username_sess']);
			$ticket->addChild("staffID", "TBD");
			$tickets->saveXML("tickets.xml");



//==============USE SESSIONS

		header("Location: userIndex.php");
	}

} 

else {

$str = <<<XML
	<xml version="1.0">
	  <tickets>
	  </tickets>
	</xml>
XML;
	$tickets = simplexml_load_string($str);
	$tickets->saveXML("tickets.xml");
	print "File created";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Form</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>
	<h1>Create a New Ticket</h1>
	<form method="post" name="add-ticket">
		<div>
			<label>Date:</label>
			<input type="date" name="input-date">
		</div>
		<div>
			<label>Category:</label>
		    <select name="category" id="input-category">
				<option value="strings">Strings</option>
				<option value="brass">Brass</option>
				<option value="percussion">Percussion</option>
				<option value="woodwinds">Woodwinds</option>
			</select>
		</div>
		<div>
			<label>Description:</label>
			<input type="textbox" name="input-desc">
		</div>
		<div>
			<label>Message:</label>
			<input type="textbox" name="input-message">
		</div>
		<input type="submit" name="btn-submit">
	</form>
		<a href="userIndex.php">Home</a>
</body>
</html>