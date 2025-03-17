<?php
include('db.php'); // Подключаем базу данных

// Проверка, передан ли ID пользователя
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Удаляем пользователя по ID
    $sql = "DELETE FROM users WHERE id = '$id'";

    if ($db->query($sql) === TRUE) {
        echo "Пользователь успешно удалён!";
    } else {
        echo "Ошибка: " . $db->error;
    }
} else {
    echo "ID не передан!";
}
?>