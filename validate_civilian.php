<?php
include 'connect.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Προστασία από SQL Injection με χρήση Prepared Statements
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM civilian WHERE username_civ = ? AND password_civ = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total = $row['total'];

if ($total > 0) {
    $_SESSION["logged"] = 1;
    $_SESSION['username'] = $username; // Αποθήκευση του ονόματος χρήστη στη συνεδρία
    $_SESSION['type'] = "civilian";

    include 'check_session.php';


    header("Location: menu_civilian.html");

    exit(); // Βεβαιωθείτε ότι έχετε την εντολή exit μετά από header
} else {
    header("Location: index.php");
    exit();
}
?>
