<?php
// Database connection
$servername = "localhost";
$username = "root";  // Use your MySQL username
$password = "Mb20022002";      // Use your MySQL password if you set one
$dbname = "lab_backend"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for form data
$title = $author = $publication_year = $genre = "";
$message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Validate and sanitize input
    $title = htmlspecialchars(trim($_POST["title"]));
    $author = htmlspecialchars(trim($_POST["author"]));
    $publication_year = filter_var($_POST["publication_year"], FILTER_SANITIZE_NUMBER_INT);
    $genre = htmlspecialchars(trim($_POST["genre"]));
    
    // Basic validation
    if (empty($title) || empty($author)||empty($genre) || empty($publication_year)) {
        $message = "Please fill in all required fields.";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO books (title, author, publication_year, genre) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $title, $author, $publication_year, $genre);
        
        if ($stmt->execute()) {
            $message = "New book added successfully";
            // Clear form data
            $title = $author = $publication_year = $genre = "";
        } else {
            $message = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

// Search for books
$search_results = array();
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_term = htmlspecialchars(trim($_GET['search_term']));
    
    if (!empty($search_term)) {
        // Search by ID if the search term is a number, otherwise search by title
        if (is_numeric($search_term)) {
            $sql = "SELECT * FROM books WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $search_term);
        } else {
            $search_term = "%$search_term%";
            $sql = "SELECT * FROM books WHERE title LIKE ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $search_term);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
        
        $stmt->close();
    }
}

// Delete a book
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);
    
    if (!empty($id)) {
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $message = "Book deleted successfully";
        } else {
            $message = "Error deleting book: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

// Get all books for display
$all_books = array();
$sql = "SELECT * FROM books ORDER BY id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $all_books[] = $row;
    }
}

$conn->close();
?>


