<?php
include 'connect.php';
session_start();

// Ανάκτηση των στοιχείων χρήστη από την φόρμα
$username = $_POST['username'];
$password = $_POST['password'];

// Προστασία από SQL Injection με χρήση Prepared Statements
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM admin WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total = $row['total'];

// Έλεγχος αν ο χρήστης υπάρχει στη βάση δεδομένων
if ($total > 0) {
    $_SESSION['logged'] = 1;
   // $_SESSION['username'] = $username; // Αποθήκευση του ονόματος χρήστη στη συνεδρία
    $_SESSION['type'] = "admin";


    include 'check_session.php';


    header("Location: menu_admin.html");

    exit(); // Βεβαιωθείτε ότι έχετε την εντολή exit μετά από header
} else {
    header("Location: index.php");
    exit();
}
?>
