<?php include 'config.php'; ?>

<?php
$id = $_GET['id'];


if (!isset($id) || !is_numeric($id)) {
    header("Location: index.php?error=Invalid order ID.");
    exit();
}


$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?success=Order deleted successfully.");
} else {
    header("Location: index.php?error=Error deleting order: " . $conn->error);
}

$stmt->close();
$conn->close();
?>