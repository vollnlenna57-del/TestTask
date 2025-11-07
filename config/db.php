<?php
$servername = getenv('DB_HOST');  
$username = getenv('DB_USER');         
$password = getenv('DB_PASSWORD');             
$dbname = getenv('DB_NAME');       

if (!$servername || !$username || !$dbname) {
    die("Не настроены переменные окружения. Проверьте .env файл");
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>