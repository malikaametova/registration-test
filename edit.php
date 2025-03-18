<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT id, name, email, phone FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Пользователь не найден.";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $sql = "UPDATE users SET name = ?, phone = ?, email = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssi", $name, $phone, $email, $id);

        if ($stmt->execute()) {
            echo "Данные обновлены.";
            header("Location: list_users.php");
            exit;
        } else {
            echo "Ошибка обновления: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Редактировать пользователя</title>
</head>
<body>
    <form method="POST">
        Имя: <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"><br>
        Телефон: <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>
        <button type="submit">Сохранить</button>
    </form>
</body>
</html>