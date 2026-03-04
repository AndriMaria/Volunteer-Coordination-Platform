<?php
global $conn;
session_start(); // Start the session to use session variables

include('connect.php');

// Get POST parameters
$name = $_POST['item_name'];
$peopleCount = $_POST['people_count'];
$status_request = 'PENDING'; // Initial status
$username = $_SESSION['username']; // Assuming the username is stored in the session

// Check if the connection is successful
if ($conn) {
    // Prepare the SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO new_request (username, item_name, people_count, request_date, status_request, acceptance_date, completion_date) VALUES (?, ?, ?, CURDATE(), ?, NULL, NULL)");

    // Bind the parameters to the SQL query
    $stmt->bind_param("ssis", $username, $name, $peopleCount, $status_request);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Data submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error connecting to the database.";
}
?>
