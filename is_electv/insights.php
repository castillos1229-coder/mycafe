<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Insights - ☕CofFia☕e</title>
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>☕</text></svg>">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕CofFia☕</h1>
            <p>Unlock the secrets of our cafe's success</p>
        </header>
        
        <main>
            <section class="insights-section">
                <h2>Top-Selling Item</h2>
                <div class="insight-card">
                    <?php
                    $result = $conn->query("SELECT name FROM menu WHERE id = (SELECT item_id FROM orders GROUP BY item_id ORDER BY COUNT(*) DESC LIMIT 1)");
                    $row = $result->fetch_assoc();
                    echo $row ? "<p>Most ordered: <strong>{$row['name']}</strong></p>" : "<p>No orders yet. Start brewing some sales!</p>";
                    ?>
                </div>
            </section>
            
            <section class="insights-section">
                <h2>Total Sales per Category</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT category, SUM(price * quantity) AS total_sales FROM menu m JOIN orders o ON m.id = o.item_id 
                                                    GROUP BY category");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><td>{$row['category']}</td><td>\${$row['total_sales']}</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No sales data available yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section class="insights-section">
                <h2>Average Order Value Comparison</h2>
                <div class="insight-card">
                    <?php
                    $avg_order_result = $conn->query("SELECT AVG(price * quantity) AS avg_order FROM menu m JOIN orders o ON m.id = o.item_id");
                    $avg_order = $avg_order_result->fetch_assoc()['avg_order'];
                    
                    $overall_avg_result = $conn->query("SELECT AVG(price) AS overall_avg FROM menu");
                    $overall_avg = $overall_avg_result->fetch_assoc()['overall_avg'];
                    
                    if ($avg_order !== null && $overall_avg !== null) {
                        echo "<p>Average order value: <strong>$" . number_format($avg_order, 2) . "</strong></p>";
                        echo "<p>Overall menu average price: <strong>$" . number_format($overall_avg, 2) . "</strong></p>";
                    } else {
                        echo "<p>Not enough data to calculate averages yet.</p>";
                    }
                    ?>
                </div>
            </section>
            
            <a href="index.php" class="btn-secondary">Back to Dashboard</a>
        </main>
        
        <footer>
            <p></p>
        </footer>
    </div>
</body>
</html>