<?php
include 'connect.php';


header('Content-Type: application/json');

session_start();
$civilianUsername = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Διαχείριση αιτημάτων POST (για ακύρωση προσφοράς)
    $offerId = isset($_POST['offerId']) ? intval($_POST['offerId']) : 0;

    if ($offerId > 0) {
        // Διαγραφή προσφοράς από τη βάση δεδομένων μόνο αν ανήκει στον τρέχοντα χρήστη και είναι σε κατάσταση 'Pending'
        $query = "DELETE FROM offers WHERE id = ? AND civilian_username = ? AND status = 'Pending'";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['error' => 'Σφάλμα προετοιμασίας δήλωσης: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("is", $offerId, $civilianUsername);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => 'Η προσφορά διαγράφηκε επιτυχώς.']);
            } else {
                echo json_encode(['error' => 'Η προσφορά δεν βρέθηκε ή δεν είναι σε κατάσταση Pending.']);
            }
        } else {
            echo json_encode(['error' => 'Σφάλμα κατά την εκτέλεση της δήλωσης: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Μη έγκυρο ID προσφοράς.']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Διαχείριση αιτημάτων GET (για ανάκτηση προσφορών χρήστη)
    if (!$civilianUsername) {
        echo json_encode(['error' => 'Σφάλμα: Δεν είστε συνδεδεμένος.']);
        exit;
    }

    // Ερώτημα για την ανάκτηση των προσφορών του χρήστη με όνομα είδους
    $query = "SELECT o.id, o.announcement_id, o.item_id, o.quantity, o.status, o.created_date AS date_created, o.accepted_date, o.completed_date, i.name AS item_name
              FROM offers o
              INNER JOIN items i ON o.item_id = i.id
              WHERE o.civilian_username = ?
              ORDER BY o.created_date DESC";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo json_encode(['error' => 'Σφάλμα κατά την προετοιμασία της δήλωσης: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("s", $civilianUsername);

    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Σφάλμα κατά την εκτέλεση της δήλωσης: ' . $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();

    if (!$result) {
        echo json_encode(['error' => 'Σφάλμα κατά την ανάκτηση των προσφορών: ' . $conn->error]);
        exit;
    }

    $offers = [];
    while ($row = $result->fetch_assoc()) {
        $offers[] = $row;
    }

    echo json_encode($offers);

    $stmt->close();
} else {
    echo json_encode(['error' => 'Μη έγκυρη μέθοδος HTTP.']);
}

$conn->close();
?>
