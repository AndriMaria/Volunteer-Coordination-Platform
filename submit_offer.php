<?php
include 'connect.php';
session_start();

// Έλεγχος αν η συνεδρία είναι ενεργή
if (!isset($_SESSION['username'])) {
    echo 'Σφάλμα: Δεν είστε συνδεδεμένος.';
    exit;
}

$civilianUsername = $_SESSION['username'];

// Ανάκτηση δεδομένων από τη φόρμα
$announcementId = isset($_POST['announcementId']) ? intval($_POST['announcementId']) : 0;
$itemId = isset($_POST['itemId']) ? intval($_POST['itemId']) : 0;
$quantity = isset($_POST['quantity']) ? $conn->real_escape_string($_POST['quantity']) : '';

if ($announcementId <= 0 || $itemId <= 0 || empty($quantity)) {
    echo 'Σφάλμα: Ελλιπή δεδομένα.';
    exit;
}

// Εισαγωγή της προσφοράς στη βάση δεδομένων
$query = "INSERT INTO offers (civilian_username, announcement_id, item_id, quantity) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("siis", $civilianUsername, $announcementId, $itemId, $quantity);

if ($stmt->execute()) {
    echo 'Η προσφορά σας υποβλήθηκε επιτυχώς!';
} else {
    echo 'Σφάλμα κατά την υποβολή της προσφοράς.';
}

$stmt->close();
$conn->close();
?>
