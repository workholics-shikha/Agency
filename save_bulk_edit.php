<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "desiantiques_agency");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Loop through the posted data and update rows
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['theater_name'] as $id => $theater_name) {
        $thcode = $_POST['thcode'][$id];
        $caption = $_POST['caption'][$id];
        $airdate = $_POST['airdate'][$id];
        $starttime = $_POST['starttime'][$id];
        $endtime = $_POST['endtime'][$id];
        $region = $_POST['region'][$id];
        $district = $_POST['district'][$id];

        // Escape input values to prevent SQL injection
        $theater_name = $conn->real_escape_string($theater_name);
        $thcode = $conn->real_escape_string($thcode);
        $caption = $conn->real_escape_string($caption);
        $airdate = $conn->real_escape_string($airdate);
        $starttime = $conn->real_escape_string($starttime);
        $endtime = $conn->real_escape_string($endtime);
        $region = $conn->real_escape_string($region);
        $district = $conn->real_escape_string($district);

        // Update query
        $sql = "UPDATE maintable SET 
                    theater_name = '$theater_name', 
                    thcode = '$thcode', 
                    caption = '$caption', 
                    airdate = '$airdate', 
                    starttime = '$starttime', 
                    endtime = '$endtime', 
                    region = '$region', 
                    district = '$district' 
                WHERE id = $id";

        // Execute the query
        if (!$conn->query($sql)) {
            echo "Error updating record ID $id: " . $conn->error . "<br>";
        }
    }
    echo "All records updated successfully!";
}
$conn->close();
