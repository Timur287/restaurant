<?php

require 'connect.php';
require 'functions.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_table'])) {
        createTable($_POST['table_name'], $_POST['capacity']);
        $message[] = "Столик успешно создан!";
    }
    elseif (isset($_POST['edit_table'])) {
        editTable($_POST['table_id'], $_POST['table_name'], $_POST['capacity']);
        $message[] = "Столик отредактирован!";
    }
    echo '<script>setTimeout(\'location="tables.php"\', 1000)</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление столиками</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php' ?>
<main id="main">
    <?php include 'message.php' ?>
    <div class="title">Управление столиками</div>
    <div class="title">Создать новый столик</div>
    <form method="post">
        <label>Номер столика:</label>
        <input type="text" id="table_name" name="table_name" required>
        <label>Вместимость:</label>
        <input type="number" id="capacity" name="capacity" required>
        <button type="submit" name="create_table">Создать</button>
    </form>

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
                         onclick="openModal('editTable', {'editTable_table_id': '<?= $row['table_id'] ?>', 'editTable_table_name': '<?= $row['table_name'] ?>'})">
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

    <dialog class="modal-content" id="editTable">
        <span class="close-modal" onclick="window.editTable.close()">&times;</span>
        <div class="title">Редактировать столик</div>
        <form method="post">
            <label>ID:</label>
            <input class="ro-input" type="text" name="table_id" id="editTable_table_id" readonly required>
            <label>Номер:</label>
            <input type="text" name="table_name" id="editTable_table_name" required>
            <label>Новая вместимость:</label>
            <input type="number" name="capacity" required>
            <button type="submit" name="edit_table">Редактировать</button>
        </form>
    </dialog>
</main>
<script src="js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
