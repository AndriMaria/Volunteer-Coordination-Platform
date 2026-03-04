<?php
global $conn;
include 'connect.php';

$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';

$query = "SELECT 
             SUM(CASE WHEN status_request = 'PENDING' THEN 1 ELSE 0 END) AS newRequests,
             SUM(CASE WHEN status_request = 'COMPLITED' THEN 1 ELSE 0 END) AS completedRequests
         FROM new_request
         WHERE request_date BETWEEN ? AND ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);

$stmt->close();
$conn->close();
?>
