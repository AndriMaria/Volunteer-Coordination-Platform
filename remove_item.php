<?php
include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['id'];



    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Διαγραφή του προϊόντος από τη βάση δεδομένων
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $itemId);

    if ($stmt->execute()) {
        echo 'Το προϊόν αφαιρέθηκε επιτυχώς.';
    } else {
        echo 'Σφάλμα κατά την αφαίρεση του προϊόντος.';
    }

    $stmt->close();
    $conn->close();
}
?>
