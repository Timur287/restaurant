<?php

require 'connect.php';
require 'functions.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_order'])) {
        $conn = openConn();
        $selectedDishes = $_POST['dish_id'] ?? [];

        $sql = "INSERT INTO orders (date_created) VALUES (NOW())";
        if ($conn->query($sql) === TRUE) {
            $orderId = $conn->insert_id;
            foreach ($selectedDishes as $dishId) {
                $sql = "INSERT INTO order_items (order_id, dish_id) VALUES ('$orderId', '$dishId')";
                if ($conn->query($sql) !== TRUE) {
                    $message[] = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            $message[] = "Заказ успешно создан!";
        }
        else {
            $message[] = "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    echo '<script>setTimeout(\'location="orders.php"\', 1000)</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>
<main id="main">
    <?php include 'message.php'; ?>
    <section class="tables">
        <div class="title">Забронированные столики</div>
        <div class="cards">
            <?php
            $conn = openConn();
            $tables = $conn->query("SELECT * FROM `tables` WHERE status='occupied'") or die('query failed');
            if ($tables->num_rows > 0) {
                while ($row = $tables->fetch_assoc()) {
                    ?>
                    <div class="card <?= $row['status'] ?>" title="Открыть"
                         onclick="openModal('createOrder', {'createOrder_table_id': '<?= $row['table_id'] ?>'})">
                        <div class="description">
                            <label>ID:</label>
                            <div class="table-id"><?= $row['table_id'] ?></div>
                            <label>Номер:</label>
                            <div class="table-name"><?= $row['table_name'] ?></div>
                            <label>Вместимость:</label>
                            <div class="capacity"><?= $row['capacity'] ?></div>
                            <label>Статус:</label>
                            <div class="status"><?= $row['status'] ?></div>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                echo '<p class="empty">"There are no tables"</p>';
            }
            closeConn($conn);
            ?>
        </div>
    </section>

    <dialog class="modal-content" id="createOrder">
        <span class="close-modal"
              onclick="window.createOrder.close()">&times;</span>
        <div class="title">Создать заказ</div>
        <form method="post">
            <label>ID столика:</label>
            <input class="ro-input" type="text" name="table_id"
                   id="createOrder_table_id" readonly required>
            <div id="addDishButton">
                <button type="button" onclick="showDishOptions()">Добавить блюдо</button>
            </div>
            <div id="selectedDishes"></div>
            <div id="dishOptions" style="display: none;">
                <select id="dishSelect">
                    <?php
                    $conn = openConn();
                    $query = "SELECT * FROM `dishes`";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option data-id=" . $row['dish_id'] . " data-cost=" . $row['cost'] . ">" . $row['dish_name'] . ' - ' . $row['cost'] . "</option>";
                        }
                    }
                    closeConn($conn);
                    ?>
                </select>
                <button type="button" onclick="addSelectedDish()">+</button>
            </div>
            <div id="addAnotherDishButton" style="display: none;">
                <button type="button" onclick="showDishOptions()">Добавить ещё блюдо</button>
            </div>
            <div id="totalCost">Общая стоимость: $0</div>
            <button type="submit" name="create_order">Создать заказ</button>
        </form>
    </dialog>

    <div class="title">Заказы</div>
    <div class="cards">
        <?php
        $conn = openConn();
        $orders = $conn->query("SELECT * FROM orders") or die('query failed');
        if ($orders->num_rows > 0) {
            while ($row = $orders->fetch_assoc()) {
                ?>
                <div class="card">
                    <div class="description">
                        <label>ID:</label>
                        <div class="order-id"><?= $row["order_id"] ?></div>
                        <label>Создан:</label>
                        <div class="date-created"><?= $row["date_created"] ?></div>
                        <div>Состав:</div>
                        <ul>
                            <?php
                            $order_id = $row["order_id"];
                            $dishes = "SELECT dishes.dish_name, dishes.cost FROM order_items
                            INNER JOIN dishes ON order_items.dish_id = dishes.dish_id
                            WHERE order_items.order_id = '$order_id'";
                            $dish = $conn->query($dishes);
                            while ($row = $dish->fetch_assoc()) {
                                echo "<li>" . $row["dish_name"] . " - $" . $row["cost"] . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
            }
        }
        else {
            echo '<p class="empty">"There are no orders"</p>';
        }
        closeConn($conn);
        ?>
    </div>
</main>
<script src="js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

