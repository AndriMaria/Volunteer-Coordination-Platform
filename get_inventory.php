<?php
include 'connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$category_ids = isset($_GET['category_ids']) ? $_GET['category_ids'] : '';

$query = "SELECT items.id, items.name, categories.name as category, items.quantity 
          FROM items 
          JOIN categories ON items.category_id = categories.id";

if (!empty($category_ids)) {
    $category_ids = explode(',', $category_ids);
    $placeholders = implode(',', array_fill(0, count($category_ids), '?'));
    $query .= " WHERE categories.id IN ($placeholders)";
}

$stmt = $conn->prepare($query);

if (!empty($category_ids)) {
    $stmt->bind_param(str_repeat('i', count($category_ids)), ...$category_ids);
}

$stmt->execute();
$result = $stmt->get_result();
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);

$stmt->close();
$conn->close();
?>
