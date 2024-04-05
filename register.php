<?php

include 'connect.php';
session_start();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $conn = openConn();
    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
    $select_admin->execute([$name]);
    $select_admin->store_result();

    if ($select_admin->num_rows() > 0) {
        $message[] = 'Пользователь с таким именем уже существует.';
    }
    elseif ($pass != $cpass) {
        $message[] = 'Пароли не совпадают.';
    }
    else {
        $insert_admin = $conn->prepare("INSERT INTO `admin` (name, password) VALUES(?,?)");
        $insert_admin->execute([$name, $cpass]);
        $message[] = 'Регистрация успешна.';
        echo '<script>setTimeout(\'location="login.php"\', 1000)</script>';
    }
    closeConn($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<?php include 'message.php' ?>
<section class="register">
    <form action="" method="POST">
        <div class="title">Зарегистрироваться</div>
        <input type="text" name="name" maxlength="20"
               placeholder="Введите имя"
               oninput="this.value = this.value.replace(/\s/g, '')"
               required>
        <input type="password" name="pass" maxlength="20"
               placeholder="Введите пароль"
               oninput="this.value = this.value.replace(/\s/g, '')"
               required>
        <input type="password" name="cpass" maxlength="20"
               placeholder="Подтвердите пароль"
               oninput="this.value = this.value.replace(/\s/g, '')"
               required>
        <button type="submit" name="submit">Зарегистрироваться</button>
        <a href="login.php">Войти в аккаунт</a>
    </form>
</section>
</body>
</html>