<?php
header('Content-Type: application/json; charset=utf-8');
include 'connect.php';

// Έλεγχος αν έχει δοθεί παράμετρος κατηγορίας
$category_id = isset($_GET['category']) ? $_GET['category'] : '';

if (!empty($category_id)) {
    // Αν δοθεί κατηγορία, φιλτράρουμε τα είδη βάσει αυτής
    $sql = "SELECT id, name, category_id, quantity FROM items WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $category_id);
} else {
    // Αν δεν δοθεί κατηγορία, επιστρέφουμε όλα τα είδη
    $sql = "SELECT id, name, category_id, quantity FROM items";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$items = array();
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);

$stmt->close();
$conn->close();
?>
