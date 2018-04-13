<?php

session_start();
$xml = '';

if(!isset($_SESSION['type'])){
	header("Location: login.php");
}

if(file_exists("tickets.xml")){
	$tickets = simplexml_load_file("tickets.xml");

	if(isset($_GET)){
		$get_id = $_GET['id'];		
		$id = $tickets->xpath('/tickets/ticket/id[text() = ' . $get_id . ']/..')[0];

		if(isset($_POST['message'])){
		header("Location: message.php");
		}
	}
} else{
	header("Location: userIndex.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Support Tickets</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body id="body">
	<h1 class="ticket_greeting">Hello <?= $_SESSION['username_sess']; ?></h1>
	<div id="ticket_wrapper">
	<h2 class="ticket_text">Ticket Details</h2>
		<?php
			echo '<h4 class="ticket_text">Ticket ID</h4>';
			echo '<p class="ticket_text">' .$id->id . '</p>';
			echo '<h4 class="ticket_text">Status</h4>';
			echo '<p class="ticket_text">' .$id->status . '</p>';
			echo '<h4 class="ticket_text">Date</h4>';
			echo '<p class="ticket_text">' .$id->date . '</p>';
			echo '<h4 class="ticket_text">Category</h4>';
			echo '<p class="ticket_text">' .$id->category . '</p>';
			echo '<h4 class="ticket_text">Customer ID</h4>';
			echo '<p class="ticket_text">' . $id->customerID . '</p>';
			echo '<h4 class="ticket_text">Staff ID</h4>';
			echo '<p class="ticket_text">' . $id->staffID . '</p>';
			echo '<h4 class="ticket_text">Description</h4>';
			echo '<p class="ticket_text">' . $id->description . '</p>';
			echo '<h3>Messages</h3>';
			echo '<table class="table">
					<thead>
						<tr>
							<td>Recipient</td>
							<td>Sender</td>
							<td>Message</td>
						</tr>
					</thead>
					<tbody>';
					//var_dump($id[0]->message);
						foreach($id[0]->message as $message){
							echo '<tr>' ;
							echo  '<td>' . $message['recipient'] . '</td>' .
								 '<td>' . $message['sender'] . '</td>'	.					
								 '<td>' . $message . '</td>';
							echo '</tr>';
						}
					echo '</tbody></table>';
				  	echo '<form method="post" name="message_form">';
				 	echo '<input type="submit" class="btn_message" name="message" value="Add Message">
				 </form>';
		?>
	</div>
	<a href="userIndex.php" class="link">Home</a>
</body>
</html>