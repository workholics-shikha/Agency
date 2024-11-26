<?php
date_default_timezone_set('Asia/Kolkata');
// Database connection (replace with your actual connection code)
$conn = new mysqli("localhost", "root", "", "desiantiques_agency");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$i = 1;
$userId = 0;

// Get the filter values from the AJAX request
$start_date = isset($_GET['start_date']) ? $conn->real_escape_string($_GET['start_date']) : '';
$end_date   = isset($_GET['end_date']) ? $conn->real_escape_string($_GET['end_date']) : '';
$theater    = isset($_GET['theater']) ? $conn->real_escape_string($_GET['theater']) : '';
$a_id       = isset($_GET['a_id']) ? intval($_GET['a_id']) : 0;

// Base query
$query = "SELECT * FROM maintable";

// Initialize an array to build conditions
$conditions = [];

// Add conditions for date range
if (!empty($start_date) && !empty($end_date)) {
    $conditions[] = "airdate BETWEEN '$start_date' AND '$end_date'";
}

// Add condition for theater name
if (!empty($theater)) {
    $conditions[] = "thcode LIKE '%$theater%'";
}

// Add condition for rono and status if a_id is provided
if ($a_id > 0) {
    $sql = "SELECT * FROM `ad` WHERE `id` = $a_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $a2 = $result->fetch_assoc();
        $rono = $conn->real_escape_string($a2['rono']);
        $conditions[] = "rono = '$rono' AND status = '1'";
    }
}

// Append conditions to the query
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

// Execute the query
$result = $conn->query($query);
  
// Check if the query was successful
if ($result === false) {
    die("Error executing query: " . $conn->error); // Show the error message if the query failed
}
 
// Check if there are results
if ($result->num_rows > 0) {
     
    while ($row = $result->fetch_row()) {
        $rows[] = $row;  // Store each row in the $rows array
    }
    
    header('Content-Type: application/json');
    print_r(json_encode($rows));
 
}  
?>
