<?php

require 'connect.php';
require 'functions.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
<main id="main">
    <div class="title">Панель администратора</div>
    <div class="cards">
        <?php
        $conn = openConn();
        ?>
        <div class="card">
            <?php
            $result = $conn->query("SELECT COUNT(*) as total FROM `reservations`");
            if ($result->num_rows != 0) {
                ?>
                <div class="description">
                    <label class="label-desc">За всё время забронировали столики:</label>
                    <div><?= $result->fetch_assoc()['total'] ?></div>
                </div>
                <?php
            }
            else {
                ?>
                <div class="description">Столики ещё не бронировали</div>
                <?php
            }
            ?>
        </div>
        <div class="card">
            <?php
            $result = $conn->query("SELECT COUNT(*) as total FROM `orders`");
            if ($result->num_rows != 0) {
                ?>
                <div class="description">
                    <label class="label-desc">За всё время сделали заказ:</label>
                    <div><?= $result->fetch_assoc()['total'] ?></div>
                </div>
                <?php
            }
            else {
                ?>
                <div class="description">Заказы ещё не делали</div>
                <?php
            }
            ?>
        </div>
        <div class="card">
            <?php
            $result = $conn->query("SELECT COUNT(*) as total FROM `tables`");
            if ($result->num_rows != 0) {
                ?>
                <div class="description">
                    <label class="label-desc">Всего столиков:</label>
                    <div><?= $result->fetch_assoc()['total'] ?></div>
                </div>
                <?php
            }
            else {
                ?>
                <div class="description">Столиков ещё нет</div>
                <?php
            }
            ?>
        </div>
        <div class="card">
            <?php
            $result = $conn->query("SELECT COUNT(*) as total FROM `dishes`");
            if ($result->num_rows != 0) {
                ?>
                <div class="description">
                    <label class="label-desc">Всего блюд в меню:</label>
                    <div><?= $result->fetch_assoc()['total'] ?></div>
                </div>
                <?php
            }
            else {
                ?>
                <div class="description">Блюд ещё нет</div>
                <?php
            }
            ?>
        </div>
        <div class="card">
            <?php
            $result = $conn->query("SELECT SUM(dish_price) as total_sum FROM `order_items`");
            if ($result->num_rows != 0) {
                ?>
                <div class="description">
                    <label class="label-desc">За всё время продали блюд на:</label>
                    <div>$<?= $result->fetch_assoc()['total_sum'] ?></div>
                </div>
                <?php
            }
            else {
                ?>
                <div class="description">Ещё ничего не продали</div>
                <?php
            }
            closeConn($conn);
            ?>
        </div>
    </div>

</main>
<script src="js/script.js"></script>
<script type="module"
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

