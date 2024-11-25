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
    $conditions[] = "theater_name LIKE '%$theater%'";
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
    // Output the data of each row
    $i = 0;
    while ($row = $result->fetch_assoc()) {

        $i++;

        echo "<tr><td> $i </td><td><input type='text' name='theater_name[" . $row['id'] . "]' value='" . $row['theater_name'] . "'></td>";
        echo "<td><input type='text' name='thcode[" . $row['id'] . "]' value='" . $row['thcode'] . "'></td>";
        echo "<td><input type='text' name='caption[" . $row['id'] . "]' value='" . $row['caption'] . "'></td>";
        echo "<td><input type='date' name='airdate[" . $row['id'] . "]' value='" . date("Y-m-d", strtotime($row['airdate'])) . "'></td>";
        echo "<td><input type='time' name='starttime[" . $row['id'] . "]' value='" . $row['starttime'] . "'></td>";
        echo "<td><input type='time' name='endtime[" . $row['id'] . "]' value='" . $row['endtime'] . "'></td>";
        echo "<td><input type='text' name='region[" . $row['id'] . "]' value='" . $row['region'] . "'></td>";
        echo "<td><input type='text' name='district[" . $row['id'] . "]' value='" . $row['district'] . "'></td><td>
                    <a target=\"_blank\" href=\"entryform.php?id=" . $row['id'] . "\" class=\"btn btn-primary\">
                        <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i>
                    </a>
                    
                    <a type=\"button\" class='btn btn-danger' onclick='deleteData(" . $row['id'] . ")'> <i class=\"fa fa-remove\" aria-hidden=\"true\"></i> </a>
  
                </td> </tr>";
    }
} else {

    echo "<tr><td colspan='3'>No results found.</td></tr>";
}

?>

<script>
    function deleteData(id) {

        if (confirm("Are you sure you want to delete this record?")) {

            $.ajax({
                url: 'delete_data.php',
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(response) {

                    $("#filterButton").click();
                    $("#responseMessage").html('<p class="alert alert-success">Record deleted successfully!</span>');

                    // Remove the message after 3 seconds (3000 ms)
                    setTimeout(function () {
                        $("#responseMessage").fadeOut("slow", function () {
                            $(this).html("").show(); // Clear and reset for future messages
                        });
                    }, 3000);

                }
            });

        }
    }
</script>