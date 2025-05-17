<?php
session_start();
require_once 'config/db_connect.php';

$searchResult = null;
$searchTerm = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search_term'])) {
    $searchTerm = htmlspecialchars($_GET['search_term']);
    
    if (!empty($searchTerm)) {
        if (is_numeric($searchTerm)) {
            $sql = "SELECT * FROM products WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $searchTerm);
        } else {
            $searchParam = "%$searchTerm%";
            $sql = "SELECT * FROM products WHERE name LIKE ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $searchParam);
        }
        
        $stmt->execute();
        $searchResult = $stmt->get_result();
        
        if ($searchResult->num_rows == 0) {
            $_SESSION['message'] = "No products found matching: " . $searchTerm;
            $_SESSION['message_type'] = "error";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Please enter a search term.";
        $_SESSION['message_type'] = "error";
    }
}

include 'includes/header.php';
?>

<h2>Search Products</h2>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <label for="search_term">Search by ID or Name:</label>
        <input type="text" id="search_term" name="search_term" value="<?php echo $searchTerm; ?>" required>
    </div>
    <button type="submit" class="btn">Search</button>
</form>

<?php if ($searchResult && $searchResult->num_rows > 0): ?>
    <h2>Search Results</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $searchResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
include 'includes/footer.php';
$conn->close();
?>
