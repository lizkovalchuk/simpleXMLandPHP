<?php

session_start();

if(!isset($_SESSION['type'])){
	header("Location: login.php");
}

$xml = '';

if(file_exists("tickets.xml")){
	$tickets = simplexml_load_file("tickets.xml");
}
// if(isset($_POST['view-details-admin'])){
// 	header("Location: adminDetails.php");
// }

if(!isset($_SESSION['type'])){
	header("Location: login.php");
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
				echo  '<td><a href="adminDetails.php?id='. $ticket->id.'">' . "Details" . '</a></td>' 
					. '<td>' . $ticket->status.'</td>'
					. '<td>' . $ticket->category . '</td>'
					. '<td>' . $ticket->date .'</td>'
					. '<td>' . $ticket->description .'</td>'
					. '</tr>';
			}
		?>
		</tbody>
	</table>
	<a href="logout.php">LOG OUT</a>
</body>
</html>