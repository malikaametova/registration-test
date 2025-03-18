<?php
include('db.php'); 
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . $row['email'] . "</td>
                <td><a href='edit.php?id=" . $row['id'] . "'>Редактировать</a> | <a href='delete.php?id=" . $row['id'] . "'>Удалить</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Нет пользователей!";
}
?>
