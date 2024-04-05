<?php

function openConn() {
    $servername = 'sql307.infinityfree.com'; // Имя сервера базы данных (обычно "localhost")
    $username = 'if0_36150696'; // Имя пользователя базы данных
    $password = 'Z0llt7CHnKt'; // Пароль пользователя базы данных
    $database = 'if0_36150696_rest'; // Имя базы данных
    $port = '3306';

    $conn = new mysqli($servername, $username, $password, $database,
        $port) or die("Connect failed: %s\n" . $conn->error);
    $conn->set_charset('utf8mb4');
    return $conn;
}

function closeConn($conn): void {
    $conn->close();
}