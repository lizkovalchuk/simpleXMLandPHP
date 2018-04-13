<?php

session_start();

if(!isset($_SESSION['type'])){
	header("Location: login.php");
}

$xml = '';

if(file_exists("tickets.xml")){
	$tickets = simplexml_load_file("tickets.xml");
}	else {

	$str = <<<XML
	 <xml version="1.0">
	  <tickets>
	  </tickets>
	</xml>
XML;
	$xml = simplexml_load_string($str);
	$xml->saveXML("tickets.xml");
	print "File tickets.xml created";
}

// GATHER USER INFO

if(isset($_POST['new-ticket'])){
	header("Location: userForm.php");
}
if(isset($_POST['view-details-user'])){
	header("Location: userDetails.php");
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
	<h1>Hello <?= $_SESSION['username_sess'];?></h1>
	<form action="userIndex.php" method="post">
		<input type="submit" value="Submit New Ticket" name="new-ticket">
	</form>
	<table>
		<thead>
			<tr>
			<th><strong>Link</strong></th>
			<th><strong>Status</strong></th>
			<th><strong>Category</strong></th>
			<th><strong>Date</strong></th>
			<th><strong>Description</strong></th>
			</tr>
		</thead>
		<tbody>
		<?php
				foreach ($tickets->ticket as $ticket){
				echo '<tr>';
				echo  '<td><a href="userDetails.php?id='. $ticket->id.'">' . "Details" . '</a></td>' 
					. '<td>' . $ticket->status.'</td>'
					. '<td>' . $ticket->category . '</td>'
					. '<td>' . $ticket->date .'</td>'
					. '<td>' . $ticket->description .'</td>'
					. '</tr>';
			}
		?>
		</tbody>
	</table>
</body>
	<a href="logout.php">LOG OUT</a>
</html>
