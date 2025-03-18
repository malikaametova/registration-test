<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

$db = new mysqli($servername, $username, $password, $dbname);

if ($db->connect_error) {
    die("Ошибка подключения: " . $db->connect_error);
}
?>