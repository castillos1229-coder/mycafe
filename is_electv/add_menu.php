<?php include 'config.php'; ?>

<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $category = trim($_POST['category']);
    
  
    if (empty($name) || empty($price) || empty($category)) {
        $message = 'All fields are required.';
    } elseif ($price <= 0) {
        $message = 'Price must be greater than 0.';
    } else {
        
        $stmt = $conn->prepare("SELECT id FROM menu WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $message = 'A menu item with this name already exists.';
        } else {
            
            $stmt = $conn->prepare("INSERT INTO menu (name, price, category) VALUES (?, ?, ?)");
            $stmt->bind_param("sds", $name, $price, $category);
            if ($stmt->execute()) {
                header("Location: index.php?success=Menu item added successfully.");
                exit();
            } else {
                $message = 'Error adding menu item: ' . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu-☕CofFia☕</title>
    <link rel="stylesheet" href="style.css">
   
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>☕</text></svg>">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕CofFia☕</h1>
            <p>Add a new delight to our menu</p>
        </header>
        
        <main>
            <section class="menu-form-section">
                <h2>Add New Menu Item</h2>
                <?php if ($message): ?>
                    <div class="message error"><?php echo $message; ?></div>
                <?php endif; ?>
                <form method="POST" class="form-wrapper">
                    <label for="name">Item Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" min="0.01" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                    
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category" value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>" required>
                    
                    <button type="submit" class="btn-primary">Add Item</button>
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