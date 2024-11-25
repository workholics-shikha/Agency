<?php
	$db_name = 'desiantiques_agency';
	$username = 'root';
	$password = '';
	$servername = 'localhost';

		// protected $db_name = 'desiantiques_agency';
	// protected $username = 'desiantiques_agency';
	// protected $password = 'k&nU171j4';
	// protected $host = 'localhost:3306';
ini_set('mysql.connect_timeout', 30000);
ini_set('default_socket_timeout', 30000); 

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db_name);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
