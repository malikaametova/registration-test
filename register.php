<?php
// Подключаем файл для соединения с базой данных
include('db.php');

// Проверка, что форма была отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Проверка уникальности email
    $check_email_query = "SELECT id FROM users WHERE email = '$email'";
    $check_email_result = mysqli_query($db, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        echo "<div class='error-message'>Ошибка: Этот email уже зарегистрирован.</div>"; // сообщение об ошибке в div
    } else {
        // Хеширование пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Вставка данных в таблицу базы данных
        $query = "INSERT INTO users (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$hashed_password')";

        if (mysqli_query($db, $query)) {
            echo "<div class='success-message'>Регистрация прошла успешно!</div>"; // сообщение об успехе в div
            // Можно добавить редирект на другую страницу, например, страницу авторизации
            // header("Location: login.php");
            // exit();
        } else {
            echo "<div class='error-message'>Ошибка при регистрации: " . mysqli_error($db) . "</div>"; // сообщение об ошибке в div
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css"> <!-- Подключаем style.css -->
</head>
<body>
    <div class="registration-container">
        <h1>Регистрация пользователя</h1>
        <form action="register.php" method="POST">
            <label for="name">Имя:</label>
            <input type="text" name="name" id="name" required><br>

            <label for="phone">Телефон:</label>
            <input type="text" name="phone" id="phone" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>

            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" value="Зарегистрироваться">
        </form>
    </div>
</body>
</html>