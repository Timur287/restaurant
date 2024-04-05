<?php

require 'connect.php';
require 'functions.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_dish'])) {
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' . $image;
        move_uploaded_file($image_tmp_name, $image_folder);
        addDish($_POST['dish_name'], $_POST['cost'], $image);
        $message[] = "Блюдо успешно добавлено!";
    }
    elseif (isset($_POST['edit_dish'])) {
        editDish($_POST['dish_id'], $_POST['dish_name'], $_POST['cost']);
        $message[] = "Блюдо отредактировано!";
    }
    elseif (isset($_POST['delete_dish'])) {
        deleteDish($_POST['dish_id']);
        $message[] = "Блюдо удалено!";
    }
    echo '<script>setTimeout(\'location="menu.php"\', 1000)</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
<main id="main">
    <?php include 'message.php' ?>
    <div class="title">Меню</div>
    <div class="title">Добавить новое блюдо</div>
    <form method="post" enctype="multipart/form-data">
        <label>Название блюда:</label>
        <input type="text" id="dish_name" name="dish_name" required>
        <label>Цена:</label>
        <input type="number" id="cost" name="cost" required>
        <label class="input-file">
            <input type="file" id="image" name="image"
                   accept="image/jpg, image/jpeg, image/png, image/webp"
                   required>
            <span class="choose-file">Выберите файл</span>
        </label>
        <button type="submit" name="create_dish">Добавить</button>
    </form>

    <section class="dishes">
        <div class="title">Блюда</div>
        <div class="cards">
            <?php
            $conn = openConn();
            $dishes = $conn->query("SELECT * FROM `dishes`") or die('query failed');
            if ($dishes->num_rows > 0) {
                while ($row = $dishes->fetch_assoc()) {
                    ?>
                    <div class="card" title="Открыть"
                         onclick="openModal('editDish', {'editDish_dish_id': '<?= $row['dish_id'] ?>', 'editDish_dish_name': '<?= $row['dish_name'] ?>', 'editDish_cost': '<?= $row['cost'] ?>'})">
                        <img src="../uploaded_img/<?= $row['image'] ?>"
                             alt="" class="image">
                        <div class="description">
                            <label>ID:</label>
                            <div class="dish-id"><?= $row['dish_id'] ?></div>
                            <label>Название:</label>
                            <div class="dish-name"><?= $row['dish_name'] ?></div>
                            <label>Цена:</label>
                            <div class="cost"><?= $row['cost'] ?></div>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                echo '<p class="empty">"There are no dishes"</p>';
            }
            closeConn($conn);
            ?>
        </div>
    </section>

    <dialog class="modal-content" id="editDish">
        <span class="close-modal" onclick="window.editDish.close()">&times;</span>
        <div class="title">Редактировать блюдо</div>
        <form method="post">
            <label>ID:</label>
            <input class="ro-input" type="text" name="dish_id" id="editDish_dish_id" readonly required>
            <label>Название:</label>
            <input type="text" name="dish_name" id="editDish_dish_name" required>
            <label>Новая цена:</label>
            <input type="number" name="cost" id="editDish_cost" required>
            <button type="submit" name="edit_dish">Редактировать</button>
            <button type="submit" name="delete_dish">Удалить</button>
        </form>
    </dialog>
</main>
<script src="js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

