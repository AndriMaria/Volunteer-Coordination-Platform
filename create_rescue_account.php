<?php
include 'connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_resc = $_POST['username'];
    $password_resc = $_POST['password'];  // Αποθήκευση του κωδικού όπως είναι

    // Έλεγχος αν υπάρχει ήδη το όνομα χρήστη στη βάση δεδομένων
    $check_query = "SELECT * FROM rescuer WHERE username_resc = ?";
    $stmt = $conn->prepare($check_query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username_resc);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Αν βρεθεί χρήστης με το ίδιο όνομα χρήστη
        echo "Το όνομα χρήστη υπάρχει ήδη. Παρακαλώ επιλέξτε ένα διαφορετικό όνομα χρήστη.";
    } else {
        // Εισαγωγή νέου λογαριασμού στη βάση δεδομένων
        $query = "INSERT INTO rescuer (username_resc, password_resc) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $username_resc, $password_resc);

        if ($stmt->execute()) {
            echo "Ο λογαριασμός δημιουργήθηκε επιτυχώς.";
        } else {
            echo "Σφάλμα κατά τη δημιουργία του λογαριασμού: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Μη έγκυρη μέθοδος HTTP.";
}
?>
