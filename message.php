<?php

session_start();

if(!isset($_SESSION['type'])){
	header("Location: login.php");
}

$tickets = '';
$users = simplexml_load_file("users.xml");

if(file_exists("tickets.xml")){
	$tickets = simplexml_load_file("tickets.xml");
}
if(isset($_POST['btn-submit'])){

//COLLECT INFO

		$addMessage = $_POST['input-message'];
		$addReci = $_POST['input-reci'];
		$get_id = $_SESSION['id'];		
		$get_username = $_SESSION['username_sess'];

//ADD TO XML

		$entire_ticket = $tickets->xpath('ticket/id[text() = ' . $get_id .']/parent::*')[0];
		$message = $entire_ticket->addChild("message", $addMessage);
		$message->addAttribute('recipient', $get_username);
		$message->addAttribute('sender', $addReci);	
		$tickets->asXML("tickets.xml");

//REDIRECTION AS PER USER TYPE (customer versus staff)

		if($_SESSION['type'] == 'staff' ){
			header("Location: adminDetails.php?id=" . $get_id . '&' . $get_username );
		}

		if($_SESSION['type'] == 'customer' ){
			header("Location: userDetails.php?id=" . $get_id . '&' . $get_username );
		}


}

if(isset($_POST['btn-status'])){

		$get_id = $_POST['id'];		
		$entire_ticket = $tickets->xpath('ticket/id[text() = ' . $get_id .']/parent::*')[0];
		$upStatus = $_POST['drp-status'];
		$entire_ticket->status = $upStatus;
		$tickets->asXML("tickets.xml");	
		header("Location: adminDetails.php?id=" . $get_id . '&' . $get_username);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Message</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<h1>Add A Message</h1>
	<form method="post" name="add-ticket">
		<input type="hidden" name="id" value="<?=$_GET['id']?>">
		<div>
			<label>Message:</label>
			<input type="textbox" name="input-message">
		</div>
		<div>
			<label>Recipient:</label>
			<input type="textbox" name="input-reci">
		</div>
		<div><input type="submit" name="btn-submit"></div>


		<?php
			if($_SESSION['type'] == 'staff' ){

				$get_id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
				$entire_ticket = $tickets->xpath('ticket/id[text() = ' . $get_id .']/parent::*')[0];
				$status = $entire_ticket->xpath('status[text()]')[0];

				echo '<label>Status:</label>';
				echo '<select name="drp-status">';

				if($status == "Open"){
					echo '<option value="Open" selected>Open</option>
						  <option value="Closed">Closed</option>';
				} elseif($status == "Closed"){
					echo '<option value="Open">Open</option>
						  <option value="Closed" selected>Closed</option>';
				}

				// echo	'<option value="Open">Open</option>
				// 		<option value="Closed" selected>Closed</option>
			  	echo '</select>';

				echo '<div>';
				echo '<input type="submit" name="btn-status" value="Update Status">';
				echo '</div>';
}

			?>
	</form>
	<a href="userIndex.php">Home</a>
</body>
</html>