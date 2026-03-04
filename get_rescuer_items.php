<?php
include('connect.php');

header('Content-Type: application/json');

session_start();
$rescuerUsername = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (empty($rescuerUsername)) {
    echo json_encode(['error' => 'Σφάλμα: Δεν είστε συνδεδεμένος.']);
    exit;
}

$sql = "SELECT ri.item_id, i.name AS name_item, ri.quantity 
        FROM rescuer_items ri 
        JOIN items i ON ri.item_id = i.id 
        WHERE ri.rescuer_username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $rescuerUsername);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
