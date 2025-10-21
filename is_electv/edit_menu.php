<?php include 'config.php'; ?>

<?php
$message = '';
$id = $_GET['id'];


if (!isset($id) || !is_numeric($id)) {
    header("Location: index.php?error=Invalid menu item ID.");
    exit();
}

$result = $conn->query("SELECT * FROM menu WHERE id=$id");
if ($result->num_rows == 0) {
    header("Location: index.php?error=Menu item not found.");
    exit();
}
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $category = trim($_POST['category']);
    

    if (empty($name) || empty($price) || empty($category)) {
        $message = 'All fields are required.';
    } elseif ($price <= 0) {
        $message = 'Price must be greater than 0.';
    } else {
     
        $stmt = $conn->prepare("SELECT id 
                                FROM menu 
                                WHERE name = ? AND id != ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $result_check = $stmt->get_result();
        
        if ($result_check->num_rows > 0) {
            $message = 'A menu item with this name already exists.';
        } else {
          
            $stmt = $conn->prepare("UPDATE menu 
                                    SET name = ?, price = ?, category = ? 
                                    WHERE id = ?");
            $stmt->bind_param("sdsi", $name, $price, $category, $id);
            if ($stmt->execute()) {
                header("Location: index.php?success=Menu item updated successfully.");
                exit();
            } else {
                $message = 'Error updating menu item: ' . $conn->error;
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
    <title>CofFia</title>
    <link rel="stylesheet" href="style.css">
  
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>☕</text></svg>">
</head>
<body>
    <div class="container">
        <header>
            <h1>☕CofFia☕</h1>
            <p>Edit an existing delight on our menu</p>
        </header>
        
        <main>
            <section class="menu-form-section">
                <h2>Edit Menu Item</h2>
                <?php if ($message): ?>
                    <div class="message error"><?php echo $message; ?></div>
                <?php endif; ?>
                <form method="POST" class="form-wrapper">
                    <label for="name">Item Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                    
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" min="0.01" value="<?php echo htmlspecialchars($row['price']); ?>" required>
                    
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($row['category']); ?>" required>
                    
                    <button type="submit" class="btn-primary">Update Item</button>
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