<?php
include 'connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_FILES['jsonFile']['error'] === UPLOAD_ERR_OK) {
    $filename = $_FILES['jsonFile']['tmp_name'];
    $data = file_get_contents($filename);

    if ($data === false) {
        echo "Σφάλμα κατά την ανάγνωση του αρχείου.";
        exit;
    }

    $json = json_decode($data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Σφάλμα στην αποκωδικοποίηση JSON: " . json_last_error_msg();
        exit;
    }

    // Εισαγωγή κατηγοριών
    if (isset($json['categories'])) {
        $stmt = $conn->prepare("INSERT INTO categories (id, name) VALUES (?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name)");

        if (!$stmt) {
            echo "Σφάλμα στην προετοιμασία της δήλωσης (κατηγορίες): " . $conn->error;
            exit;
        }

        foreach ($json['categories'] as $category) {
            $stmt->bind_param("is", $category['id'], $category['category_name']);
            if (!$stmt->execute()) {
                echo "Σφάλμα κατά την εκτέλεση της δήλωσης (κατηγορίες): " . $stmt->error;
            }
        }

        $stmt->close();
    }

    // Εισαγωγή ειδών
    if (isset($json['items'])) {
        $stmt = $conn->prepare("INSERT INTO items (id, name, category_id, quantity) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), category_id = VALUES(category_id), quantity = VALUES(quantity)");

        if (!$stmt) {
            echo "Σφάλμα στην προετοιμασία της δήλωσης (είδη): " . $conn->error;
            exit;
        }

        foreach ($json['items'] as $item) {
            $quantity = null;

            // Έλεγχος για το πεδίο detail_value στα details
            if (isset($item['details'])) {
                foreach ($item['details'] as $detail) {
                    if (!empty($detail['detail_value'])) {
                        $quantity = $detail['detail_value'];
                        break;
                    }
                }
            }

            $stmt->bind_param("isis", $item['id'], $item['name'], $item['category'], $quantity);
            if (!$stmt->execute()) {
                echo "Σφάλμα κατά την εκτέλεση της δήλωσης (είδη): " . $stmt->error;
            }
        }

        $stmt->close();
    }

    echo "Τα δεδομένα φορτώθηκαν επιτυχώς.";
} else {
    echo "Σφάλμα κατά τη φόρτωση του αρχείου.";
}

$conn->close();
?>

