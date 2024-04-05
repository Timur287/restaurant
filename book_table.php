<?php
require 'connect.php';
require 'functions.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_reservation'])) {
        createReservation($_POST['table_id'], $_POST['arrival_time'],
            $_POST['departure_time'], $_POST['customer_name'],
            $_POST['contact_number']);
        $message[] = "Бронирование успешно создано!";
    }
    elseif (isset($_POST['cancel_reservation'])) {
        cancelReservation($_POST['reservation_id']);
        $message[] = "Бронирование успешно отменено!";
    }
    elseif (isset($_POST['update_reservation_time'])) {
        updateReservationTime($_POST['reservation_id'],
            $_POST['arrival_time'], $_POST['departure_time']);
        $message[] = "Время бронирования успешно обновлено!";
    }
    echo '<script>setTimeout(\'location="book_table.php"\', 1000)</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление бронированием</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body onload="showDefaultData()">
<?php include 'header.php' ?>
<main id="main">
    <?php include 'message.php' ?>
    <div class="title">Управление бронированием</div>
    <section class="tables">
        <div class="title">Столики</div>
        <div class="cards">
            <?php
            $conn = openConn();
            $tables = $conn->query("SELECT * FROM `tables`") or die('query failed');
            if ($tables->num_rows > 0) {
                while ($row = $tables->fetch_assoc()) {
                    ?>
                    <div class="card <?= $row['status'] ?>" title="Открыть"
                         onclick="openModal('createRes', {'createRes_table_id': '<?= $row['table_id'] ?>'})">
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

    <dialog class="modal-content" id="createRes">
        <span class="close-modal"
              onclick="window.createRes.close()">&times;</span>
        <div class="title">Создать бронирование</div>
        <form method="post">
            <label>ID столика:</label>
            <input class="ro-input" type="text" name="table_id"
                   id="createRes_table_id" readonly required>
            <label>Время прибытия:</label>
            <input type="datetime-local" name="arrival_time" id="createRes_arrive" onchange="setDepartureTime('createRes_arrive', 'createRes_departure')" required>
            <label>Время ухода:</label>
            <input type="datetime-local" name="departure_time" id="createRes_departure">
            <label>Имя клиента:</label>
            <input type="text" name="customer_name" required>
            <label>Контактный номер:</label>
            <input type="text" name="contact_number" required>
            <button type="submit" name="create_reservation">Создать бронирование</button>
        </form>
    </dialog>

    <section class="reservations">
        <div class="title">Забронированные столики</div>
        <div class="choose">
            <label for="selected_date">Выберите дату:</label>
            <input type="date" id="selected_date" name="selected_date" required>
            <button onclick="showData()">Показать</button>
        </div>
        <div class="cards" id="reservationsContainer"></div>
    </section>

    <dialog class="modal-content" id="editRes">
        <span class="close-modal"
              onclick="window.editRes.close()">&times;</span>
        <form method="post">
            <div class="title">Обновить время брони</div>
            <label>ID бронирования:</label>
            <input class="ro-input" type="text" name="reservation_id"
                   id="editRes_reservation_id" readonly required>
            <label>Новое время прибытия:</label>
            <input type="datetime-local" name="arrival_time" id="editRes_arrive" onchange="setDepartureTime('editRes_arrive', 'editRes_departure')" required>
            <label>Новое время ухода:</label>
            <input type="datetime-local" name="departure_time" id="editRes_departure" required>
            <button type="submit" name="update_reservation_time">Обновить</button>
        </form>
    </dialog>
</main>
<script src="js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
