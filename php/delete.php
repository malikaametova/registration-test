<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Validate the ID to prevent SQL injection
    if (!is_numeric($id)) {
        echo "Недопустимый ID.";
        exit;
    }

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: list_users.php");
        exit;
    } else {
        echo "Ошибка удаления: " . $stmt->error;
    }
} else {
    echo "ID не передан!";
}
?>