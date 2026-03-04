<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
    echo json_encode(['sessionExpired' => true]);
} else {
    echo json_encode(['sessionExpired' => false]);
}
?>
