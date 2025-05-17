<?php
session_start();
require_once 'config/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Product deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting product: " . $stmt->error;
        $_SESSION['message_type'] = "error";
    }
    $stmt->close();
}

header("Location: index.php");
exit();
?>
