<?php

require 'connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_date'])) {
    $conn = openConn();
    $selected_date = $_POST['selected_date'];
    $sql = "SELECT * FROM `reservations` WHERE DATE(arrival_time) = DATE('$selected_date') ORDER BY arrival_time ASC";
    $reservations = $conn->query($sql) or die('query failed');

    if ($reservations->num_rows > 0) {
        while ($row = $reservations->fetch_assoc()) {
            echo '
            <form class="card" method="post" style="padding: 0;" title="Открыть">
                <div class="description" onclick="openModal(\'editRes\', {\'editRes_reservation_id\': ' . $row['reservation_id'] . ', \'editRes_arrive\': \'' . $row['arrival_time'] . '\'})">
                    <label>ID бронирования:</label>
                    <input class="ro-input" type="hidden" name="reservation_id" value="' . $row['reservation_id'] . '" readonly required></input>
                    <div class="table-id">' . $row['reservation_id'] . '</div>
                    <label>ID столика:</label>
                    <div class="table-id">' . $row['table_id'] . '</div>
                    <label>Время прибытия:</label>
                    <div class="arrive">' . $row['arrival_time'] . '</div>
                    <label>Время ухода:</label>
                    <div class="departure">' . $row['departure_time'] . '</div>
                    <label>Имя клиента:</label>
                    <div class="name">' . $row['customer_name'] . '</div>
                    <label>Контактный номер:</label>
                    <div class="number">' . $row['contact_number'] . '</div>
                </div>
                <button type="submit" name="cancel_reservation">Отменить бронь</button>
            </form>
            ';
        }
    }
    else {
        echo '<p class="empty">"На выбранную дату нет забронированных столиков"</p>';
    }
    closeConn($conn);
}
