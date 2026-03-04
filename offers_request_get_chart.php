<?php
include 'connect.php';

$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';

$query = "SELECT 
             SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS newOffers,
             SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completedOffers
         FROM offers
         WHERE created_date BETWEEN ? AND ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);

$stmt->close();
$conn->close();
?>
