<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Создаем подключение
$db = new mysqli($servername, $username, $password, $dbname);  // Изменено: присваиваем соединение переменной $db

// Проверка подключения
if ($db->connect_error) {
    die("Ошибка подключения: " . $db->connect_error);
}

//echo "Подключение успешно!"; //  Раскомментируй для проверки подключения
?>