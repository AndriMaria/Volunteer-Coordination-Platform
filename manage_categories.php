<?php
include 'connect.php';

$categoryName = $_POST['categoryName'];
$categoryId = isset($_POST['categorySelect']) ? $_POST['categorySelect'] : null;

if ($categoryId) {
    // Ενημέρωση υπάρχουσας κατηγορίας
    $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
    $stmt->bind_param("si", $categoryName, $categoryId);
} else {
    // Προσθήκη νέας κατηγορίας
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $categoryName);
}

if ($stmt->execute()) {
    echo "Η κατηγορία ενημερώθηκε επιτυχώς";
} else {
    echo "Σφάλμα: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
