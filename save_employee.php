<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $last_name = trim($_POST['last_name']);
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $birth_date = $_POST['birth_date'];
    $passport = str_replace(' ', '', trim($_POST['passport']));
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $department_id = (int)$_POST['department_id'];
    $position_id = (int)$_POST['position_id'];
    $salary = (float)$_POST['salary'];
    $hire_date = $_POST['hire_date'];

    if ($id) {
        $sql = "UPDATE employees SET 
                last_name = ?, first_name = ?, middle_name = ?, birth_date = ?, 
                passport = ?, phone = ?, email = ?, address = ?, 
                department_id = ?, position_id = ?, salary = ?, hire_date = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssiidsi", 
            $last_name, $first_name, $middle_name, $birth_date,
            $passport, $phone, $email, $address,
            $department_id, $position_id, $salary, $hire_date, $id
        );
    } else {
        $sql = "INSERT INTO employees 
                (last_name, first_name, middle_name, birth_date, passport, phone, email, address, department_id, position_id, salary, hire_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssiids", 
            $last_name, $first_name, $middle_name, $birth_date,
            $passport, $phone, $email, $address,
            $department_id, $position_id, $salary, $hire_date
        );
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        die("Ошибка: " . $conn->error);
    }
}
?>