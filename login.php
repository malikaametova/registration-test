<?php
session_start();
include('db.php'); // Подключаем файл с настройками базы данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']); // Используем email
    $password = $_POST['password'];

    // Запрос в базу данных
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $email); // Используем email в запросе
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Проверяем пароль
        if (password_verify($password, $row['password'])) {
            // Успешный вход
            $_SESSION['user_id'] = $row['id']; // Сохраняем ID пользователя в сессии
            header('Location: welcome.php'); // Перенаправляем на защищенную страницу
            exit();
        } else {
            $error = "Неверное имя пользователя или пароль.";
        }
    } else {
        $error = "Неверное имя пользователя или пароль.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница входа</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Вход</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Войти</button>
            </div>
            <p><a href="#">Забыли пароль?</a></p>
            <p><a href="register.php">Регистрация</a></p>
        </form>
    </div>
</body>
</html>
