<?php
include('db.php');

$sql = "SELECT id, name, email FROM users";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Список пользователей</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Имя</th><th>Email</th><th>Действия</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td><a href='edit.php?id=" . htmlspecialchars($row['id']) . "'>Редактировать</a> | <a href='delete.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"Вы уверены, что хотите удалить этого пользователя?\");'>Удалить</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Пользователи не найдены.";
}
?>