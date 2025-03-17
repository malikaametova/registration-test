<?php
include('db.php'); // Подключаем базу данных

// Проверка, передан ли ID пользователя
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Получаем информацию о пользователе
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);  // 'i' для integer, предполагаем, что ID - число
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Пользователь не найден!";
        exit;
    }
    $stmt->close();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Получаем новые данные из формы
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        // Обновляем информацию в базе данных
        $sql = "UPDATE users SET name = ?, phone = ?, email = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssi", $name, $phone, $email, $id); // 's' для string, 'i' для integer
        if ($stmt->execute()) {
            echo "Данные успешно обновлены!";
        } else {
            echo "Ошибка: " . $stmt->error; // Используем $stmt->error вместо $db->error
        }
        $stmt->close();
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
    <form method="POST" action="edit.php?id=<?php echo htmlspecialchars($user['id']); ?>">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>

        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>