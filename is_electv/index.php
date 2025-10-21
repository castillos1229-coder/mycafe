<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CofFia</title>
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>☕</text></svg>">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕CofFia☕</h1>
            <p>Your cozy spot for great coffee and bites</p>
        </header>
        
        <main>
            <section class="menu-section">
                <h2>Menu Items</h2>
                <a href="add_menu.php" class="btn-primary">Add New Menu Item</a>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM menu");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['name']}</td>
                                            <td>₱{$row['price']}</td>
                                            <td>{$row['category']}</td>
                                            <td>
                                                <a href='edit_menu.php?id={$row['id']}' class='action-link'>Edit</a> | 
                                                <a href='delete_menu.php?id={$row['id']}' class='action-link delete'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No menu items found. <a href='add_menu.php'>Add one now</a>.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section class="orders-section">
                <h2>Orders</h2>
                <a href="add_order.php" class="btn-primary">Place New Order</a>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT o.id, o.customer_name, m.name 
                                                    AS item_name, o.quantity, o.order_date 
                                                    FROM orders o 
                                                    JOIN menu m 
                                                    ON o.item_id = m.id");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['customer_name']}</td>
                                            <td>{$row['item_name']}</td>
                                            <td>{$row['quantity']}</td>
                                            <td>{$row['order_date']}</td>
                                            <td>
                                                <a href='delete_order.php?id={$row['id']}' class='action-link delete'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No orders yet. <a href='add_order.php'>Place one now</a>.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section class="insights-section">
                <h2>Insights</h2>
                <a href="insights.php" class="btn-secondary">View Analytics</a>
            </section>
        </main>
        
        <footer>
            <p></p>
        </footer>
    </div>
</body>
</html>