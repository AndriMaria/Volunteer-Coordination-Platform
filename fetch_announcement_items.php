<?php
include 'connect.php';


header('Content-Type: application/json');

// Διαχείριση της παράμετρου για την επιλογή του είδους αιτήματος
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'announcements') {
        // Ερώτημα για την ανάκτηση ανακοινώσεων
        $query = "SELECT id, title, description, date_created FROM announcements ORDER BY date_created DESC";
        $result = $conn->query($query);

        if (!$result) {
            echo json_encode(['error' => 'Σφάλμα κατά την ανάκτηση των ανακοινώσεων']);
            exit;
        }

        $announcements = [];
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row;
        }

        echo json_encode($announcements);
    } elseif ($_GET['action'] == 'announcement_items') {
        // Ανάκτηση ID ανακοίνωσης
        $announcementId = isset($_GET['announcement_id']) ? intval($_GET['announcement_id']) : 0;

        if ($announcementId <= 0) {
            echo json_encode(['error' => 'Μη έγκυρο announcement_id']);
            exit;
        }

        // Ερώτημα για την ανάκτηση ειδών
        $query = "SELECT i.id, i.name FROM items i
                  INNER JOIN announcement_items ai ON i.id = ai.item_id
                  WHERE ai.announcement_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $announcementId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            echo json_encode(['error' => 'Σφάλμα κατά την ανάκτηση των ειδών']);
            exit;
        }

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        echo json_encode($items);

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Μη έγκυρη ενέργεια']);
    }
} else {
    echo json_encode(['error' => 'Λείπει η παράμετρος action']);
}

$conn->close();
?>
