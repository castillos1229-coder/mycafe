<?php include 'config.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $conn->query("INSERT INTO orders (customer_name, item_id, quantity) VALUES ('$customer_name', '$item_id', '$quantity')");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order - ☕CofFia☕</title>
    <link rel="stylesheet" href="style.css">
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>☕</text></svg>">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕CofFia☕</h1>
            <p>Place your order and enjoy the aroma</p>
        </header>
        
        <main>
            <section class="order-form-section">
                <h2>Place a New Order</h2>
                <form method="POST" class="form-wrapper">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                    
                    <label for="item_id">Select Item:</label>
                    <select id="item_id" name="item_id" required>
                        <?php
                        $result = $conn->query("SELECT id, name FROM menu");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                            }
                        } else {
                            echo "<option disabled>No items available</option>";
                        }
                        ?>
                    </select>
                    
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required>
                    
                    <button type="submit" class="btn-primary">Place Order</button>
                </form>
                <a href="index.php" class="btn-secondary">Back to Dashboard</a>
            </section>
        </main>
        
        <footer>
            <p></p>
        </footer>
    </div>
</body>
</html>