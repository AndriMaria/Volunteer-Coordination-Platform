<?php
global $conn;
session_start(); // Start the session to use session variables

include 'connect.php';



$username1 = $_SESSION['username'];

// Fetch user requests for the specific user
$stmt = $conn->prepare("SELECT * FROM new_request WHERE username = ? ORDER BY request_date DESC");
$stmt->bind_param("s", $username1);
$stmt->execute();
$result = $stmt->get_result();

$requests = array();
while ($row = $result->fetch_assoc()) {
    // Check if specific columns in the row are null and handle it accordingly
    $row['acceptance_date'] = is_null($row['acceptance_date']) ? 'null' : $row['acceptance_date'];
    $row['completion_date'] = is_null($row['completion_date']) ? 'null' : $row['completion_date'];

    // Use the status_request directly from the database
    $requests[] = $row;
}

echo json_encode($requests);

$stmt->close();
$conn->close();


?>
