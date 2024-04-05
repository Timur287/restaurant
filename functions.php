<?php

require_once 'connect.php';

// Функция для создания бронирования столика
function createReservation(
    $tableId,
    $arrivalTime,
    $departureTime,
    $customerName,
    $contactNumber
) {
    $conn = openConn();
    $reservations_sql = "INSERT INTO `reservations` (table_id, arrival_time, departure_time, customer_name, contact_number) VALUES ('$tableId', '$arrivalTime', '$departureTime', '$customerName', '$contactNumber')";
    $conn->query($reservations_sql);
    $tables_sql = "UPDATE `tables` SET status = 'occupied' WHERE table_id = '$tableId'";
    $conn->query($tables_sql);
    closeConn($conn);
}

// Функция для отмены бронирования столика
function cancelReservation($reservationId) {
    $conn = openConn();
    $reservationInfo = $conn->query("SELECT table_id FROM `reservations` WHERE reservation_id = '$reservationId'")->fetch_assoc();
    $tableId = $reservationInfo['table_id'];

    $reservations_sql = "DELETE FROM `reservations` WHERE reservation_id = '$reservationId'";
    $conn->query($reservations_sql);
    $tables_sql = "UPDATE `tables` SET status = 'available' WHERE table_id = '$tableId'";
    $conn->query($tables_sql);
    closeConn($conn);
}

// Функция для изменения времени бронирования столика
function updateReservationTime($reservationId, $arrivalTime, $departureTime) {
    $conn = openConn();
    $sql = "UPDATE `reservations` SET arrival_time = '$arrivalTime', departure_time = '$departureTime' WHERE reservation_id = '$reservationId'";
    $conn->query($sql);
    closeConn($conn);
}

function createTable($table_name, $capacity) {
    $conn = openConn();
    $sql = "INSERT INTO `tables` (table_name, capacity, status) VALUES ('$table_name', '$capacity', 'available')";
    $conn->query($sql);
    closeConn($conn);
}

function editTable($table_id, $table_name, $capacity) {
    $conn = openConn();
    $sql = "UPDATE `tables` SET capacity='$capacity', table_name='$table_name' WHERE table_id='$table_id'";
    $conn->query($sql);
    closeConn($conn);
}

function updateTableStatus() {
    $message = NULL;
    $conn = openConn();
    date_default_timezone_set('Europe/Moscow');
    $currentDate = (new DateTime())->format("Y-m-d H:i:s");

    $sql = "UPDATE `tables` AS t JOIN `reservations` AS r ON t.table_id = r.table_id SET t.status = 'available' WHERE (TIMESTAMP(r.departure_time) < TIMESTAMP('$currentDate') OR TIMESTAMP(r.arrival_time) > TIMESTAMP('$currentDate')) AND t.status = 'occupied'";
    if (!$conn->query($sql)) {
        $message = "Ошибка при обновлении статуса столиков: " . $conn->error;
    }

    $sql = "UPDATE `tables` AS t JOIN `reservations` AS r ON t.table_id = r.table_id SET t.status = 'occupied' WHERE (TIMESTAMP(r.departure_time) > TIMESTAMP('$currentDate') AND TIMESTAMP(r.arrival_time) < TIMESTAMP('$currentDate')) AND t.status = 'available'";
    $conn->query($sql);

    if (!$conn->query($sql)) {
        $message = "Ошибка при обновлении статуса столиков: " . $conn->error;
    }
    closeConn($conn);
    return $message;
}

function addDish($dish_name, $cost, $image) {
    $conn = openConn();
    $sql = "INSERT INTO `dishes` (dish_name, cost, image) VALUES ('$dish_name', '$cost', '$image')";
    $conn->query($sql);
    closeConn($conn);
}

function editDish($dish_id, $dish_name, $cost) {
    $conn = openConn();
    $sql = "UPDATE `dishes` SET cost='$cost', dish_name='$dish_name' WHERE dish_id='$dish_id'";
    $conn->query($sql);
    closeConn($conn);
}

function deleteDish($dish_id) {
    $conn = openConn();
    $image = $conn->query("SELECT image FROM `dishes` WHERE dish_id = '$dish_id'");
    $row_image = $image->fetch_assoc();
    unlink('uploaded_img/' . $row_image['image']);
    $sql = "DELETE FROM `dishes` WHERE dish_id='$dish_id'";
    $conn->query($sql);
    closeConn($conn);
}