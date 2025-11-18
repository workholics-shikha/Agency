<?php
	$db_name = 'desiantiques_agency';
	$username = 'desiantiques_agency';
	$password = 'k&nU171j4';
	$servername = 'localhost';
ini_set('mysql.connect_timeout', 30000);
ini_set('default_socket_timeout', 30000); 

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db_name);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
