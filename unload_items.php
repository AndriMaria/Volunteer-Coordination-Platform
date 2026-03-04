<?php
include('connect.php');

header('Content-Type: application/json');

// Εκκίνηση συνεδρίας και έλεγχος χρήστη
session_start();
$rescuerUsername = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (empty($rescuerUsername)) {
    echo json_encode(['error' => 'Σφάλμα: Δεν είστε συνδεδεμένος.']);
    exit;
}

// Επαλήθευση αν οι παράμετροι POST είναι παρόντες
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['item_id'])) {
        echo json_encode(['error' => 'Απαιτούμενη παράμετρος λείπει.']);
        exit;
    }

    $item_id = intval($_POST['item_id']);

    $conn->begin_transaction();

    try {
        // Ελέγξτε αν το είδος υπάρχει ήδη στο φορτίο του διασώστη
        $sql = "SELECT quantity FROM rescuer_items WHERE rescuer_username = ? AND item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $rescuerUsername, $item_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $rescuer_quantity = floatval($row['quantity']);

            // Επιστροφή ποσότητας στο items
            $sql = "UPDATE items SET quantity = quantity + ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('di', $rescuer_quantity, $item_id);
            $stmt->execute();

            // Διαγραφή του στοιχείου από το φορτίο του διασώστη
            $sql = "DELETE FROM rescuer_items WHERE rescuer_username = ? AND item_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $rescuerUsername, $item_id);
            $stmt->execute();

            $conn->commit();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Το στοιχείο δεν βρέθηκε στο φορτίο του διασώστη.']);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['error' => 'Σφάλμα κατά την ενημέρωση δεδομένων.']);
    }
} else {
    echo json_encode(['error' => 'Μη έγκυρη μέθοδος αιτήματος.']);
}
?>
