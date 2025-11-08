<?php
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "UPDATE employees SET active = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>
