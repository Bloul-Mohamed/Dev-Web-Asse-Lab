<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="nav">
        <div class="container">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="search.php">Search Products</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <h1>Product Management System</h1>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="message <?php echo $_SESSION['message_type']; ?>">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>
