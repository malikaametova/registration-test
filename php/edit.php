<?php
include('db.php'); // Подключаем базу данных

// Проверка, передан ли ID пользователя
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Получаем информацию о пользователе
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = $db->query($sql); // Используем $db вместо $conn

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Пользователь не найден!";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Получаем новые данные из формы
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        // Обновляем информацию в базе данных
        $sql = "UPDATE users SET name = '$name', phone = '$phone', email = '$email' WHERE id = '$id'";

        if ($db->query($sql) === TRUE) { // Используем $db вместо $conn
            echo "Данные успешно обновлены!";
        } else {
            echo "Ошибка: " . $sql . "<br>" . $db->error; // Используем $db вместо $conn
        }
    }
} else {
    echo "ID не передан!";
    exit; // Добавлен exit, чтобы остановить выполнение скрипта
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование пользователя</title>
</head>
<body>
    <h2>Редактировать пользователя</h2>
    <form method="POST" action="edit.php?id=<?php echo $user['id']; ?>">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br><br>

        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>