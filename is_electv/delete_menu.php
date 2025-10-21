<?php include 'config.php'; ?>

<?php
$id = $_GET['id'];


$check_orders = $conn->query("SELECT COUNT(*) 
                            AS order_count FROM orders 
                            WHERE item_id = $id");
$order_count = $check_orders->fetch_assoc()['order_count'];

if ($order_count > 0) {

    header("Location: index.php?error=Cannot delete menu item because it has $order_count associated order(s). Please delete the orders first or contact admin.");
    exit();
} else {
   
    $conn->query("DELETE FROM menu WHERE id = $id");
    
  
    $check_empty = $conn->query("SELECT COUNT(*) AS item_count FROM menu");
    $item_count = $check_empty->fetch_assoc()['item_count'];
    
    if ($item_count == 0) {
        
        $conn->query("ALTER TABLE menu AUTO_INCREMENT = 1");
    }
    
    header("Location: index.php?success=Menu item deleted successfully.");
    exit();
}
?>