<?php
session_start();
require_once 'config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    
    if (empty($name) || $price <= 0 || $quantity < 0) {
        $_SESSION['message'] = "Please fill all required fields with valid values.";
        $_SESSION['message_type'] = "error";
    } else {
        $sql = "INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $name, $description, $price, $quantity);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Product added successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['message_type'] = "error";
        }
        $stmt->close();
    }
}

include 'includes/header.php';
?>

<h2>Add New Product</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="3"></textarea>
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="0" required>
    </div>
    <button type="submit" class="btn">Add Product</button>
</form>

<?php
include 'includes/footer.php';
$conn->close();
?>
