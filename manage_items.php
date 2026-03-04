<?php
include 'connect.php';

$itemName = $_POST['itemName'];
$itemCategory = $_POST['itemCategory'];
$itemQuantity = $_POST['itemQuantity'];
$itemId = isset($_POST['itemSelect']) ? $_POST['itemSelect'] : null;

if ($itemId) {
    // Ενημέρωση υπάρχοντος είδους
    $stmt = $conn->prepare("UPDATE items SET name=?, category_id=?, quantity=? WHERE id=?");
    $stmt->bind_param("sisi", $itemName, $itemCategory, $itemQuantity, $itemId);
} else {
    // Προσθήκη νέου είδους
    $stmt = $conn->prepare("INSERT INTO items (name, category_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $itemName, $itemCategory, $itemQuantity);
}

if ($stmt->execute()) {
    echo "Το είδος ενημερώθηκε επιτυχώς";
} else {
    echo "Σφάλμα: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
