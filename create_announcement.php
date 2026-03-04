<?php
include 'connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $items = isset($_POST['items']) ? json_decode($_POST['items'], true) : []; // Αναμένουμε πίνακα ID ειδών

    // Εισαγωγή ανακοίνωσης
    $query = "INSERT INTO announcements (title, description) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $title, $description);

    if ($stmt->execute()) {
        $announcementId = $stmt->insert_id; // Λάβετε το ID της ανακοίνωσης
    } else {
        die("Σφάλμα κατά την εισαγωγή της ανακοίνωσης: " . $stmt->error);
    }

    $stmt->close();

    // Εισαγωγή σχέσεων ανακοινώσεων-ειδών
    if (!empty($items)) {
        $query = "INSERT INTO announcement_items (announcement_id, item_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        foreach ($items as $itemId) {
            $stmt->bind_param("ii", $announcementId, $itemId);
            if (!$stmt->execute()) {
                echo "Σφάλμα κατά την εισαγωγή των ειδών: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
    echo "Η ανακοίνωση δημιουργήθηκε επιτυχώς.";
} else {
    echo "Μη έγκυρη μέθοδος HTTP.";
}
?>
