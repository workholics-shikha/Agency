<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "desiantiques_agency");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID is provided via POST
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convert ID to integer for security

    // Prepare the SQL query to delete the record
    $sql = "DELETE FROM maintable WHERE id = $id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No ID provided";
}

// =============== For bulk delete

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
    $ids    = $_POST['ids']; // Array of IDs
    $idList = implode(',', array_map('intval', $ids)); // Sanitize IDs

    // Perform delete operation
    $query  = "DELETE FROM maintable WHERE id IN ($idList)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(['message' => 'Selected rows deleted successfully!']);
    } else {
        echo json_encode(['message' => 'Failed to delete selected rows.']);
    }
} else {
    echo json_encode(['message' => 'Invalid request.']);
}
