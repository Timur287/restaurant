<?php

include 'connect.php';
session_start();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $conn = openConn();
    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
    $select_admin->bind_param("ss", $name, $pass);
    $select_admin->execute();
    $result = $select_admin->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];
        header('Location: index.php');
    } else {
        $message[] = 'Неверный логин или пароль.';
    }

    closeConn($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<?php include 'message.php' ?>
<section class="login">
    <form action="" method="POST">
        <div class="title">Авторизоваться</div>
        <input type="text" name="name" maxlength="20"
               placeholder="Введите имя"
               oninput="this.value = this.value.replace(/\s/g, '')" required>
        <input type="password" name="pass" maxlength="20"
               placeholder="Введите пароль"
               oninput="this.value = this.value.replace(/\s/g, '')" required>
        <button type="submit" name="submit">Войти</button>
        <a href="register.php">Зарегистрироваться</a>
    </form>
</section>

</body>
</html>