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
    if (!isset($_POST['item_id']) || !isset($_POST['quantity'])) {
        echo json_encode(['error' => 'Απαιτούμενες παράμετροι λείπουν.']);
        exit;
    }

    $item_id = intval($_POST['item_id']);
    $quantity = floatval($_POST['quantity']); // Διατηρούμε ως float

    $conn->begin_transaction();

    try {
        // Ελέγξτε αν το είδος υπάρχει ήδη στο φορτίο του διασώστη
        $sql = "SELECT quantity FROM rescuer_items WHERE rescuer_username = ? AND item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $rescuerUsername, $item_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Υπολογίστε την νέα ποσότητα
            $current_quantity = floatval($row['quantity']);
            $new_quantity = $current_quantity + $quantity;
            $sql = "UPDATE rescuer_items SET quantity = ? WHERE rescuer_username = ? AND item_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('dsi', $new_quantity, $rescuerUsername, $item_id);
        } else {
            $sql = "INSERT INTO rescuer_items (rescuer_username, item_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssi', $rescuerUsername, $item_id, $quantity);
        }
        $stmt->execute();

        // Ελέγξτε αν υπάρχει επαρκής ποσότητα στο items πριν την ενημέρωση
        $sql = "SELECT quantity FROM items WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $current_quantity = floatval($row['quantity']);
            if ($current_quantity < $quantity) {
                echo json_encode(['error' => 'Μη επαρκής ποσότητα διαθέσιμη.']);
                $conn->rollback();
                exit;
            }
            $new_quantity = $current_quantity - $quantity;
            $sql = "UPDATE items SET quantity = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('di', $new_quantity, $item_id);
            $stmt->execute();
        }

        $conn->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['error' => 'Σφάλμα κατά την ενημέρωση δεδομένων.']);
    }
} else {
    echo json_encode(['error' => 'Μη έγκυρη μέθοδος αιτήματος.']);
}
