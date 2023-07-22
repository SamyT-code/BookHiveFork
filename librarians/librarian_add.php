<?php
// Start the session and include the database connection
session_start();
include_once '../db.php';

// Check if the librarian is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the librarian is not logged in
    header('Location: librarian_login.php');
    exit();
}

// Function to sanitize input data to prevent SQL injection
function sanitize($data) {
    global $conn; // Make $conn variable available inside the function
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

// Check if the form is submitted
if (isset($_POST['add_book'])) {
    // Retrieve and sanitize form data
    $title = sanitize($_POST['title']);
    $author = sanitize($_POST['author']);
    $description = sanitize($_POST['description']);
    $genre = sanitize($_POST['genre']);

    // Perform the query to add the book
    $insert_query = "INSERT INTO Books (title, author, description, genre, checked_out_by)
                     VALUES ('$title', '$author', '$description', '$genre', -1)";
    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        echo '<div class="alert alert-success" role="alert">Book added successfully.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error adding book. Please try again later.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link rel="icon" type="image/x-icon" href="../images/bee.png">
    <link rel="stylesheet" href="../css/main.css" /> <!-- Path references upper/css to use css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
</head>
<body style="background-color: #b6d0c7">
    <!-- Logout Button START -->
    <div class="container">
        <div class="logout-btn">
            <a href="../logout.php" class="logout-btn-text">Logout</a>
        </div><!-- Logout Button END -->
        <?php
            // Include the librarian navbar
            include_once 'librarian_navbar.php';
        ?>

        <h1 style="font-weight: bold">Add Book</h1>

        <!-- Book Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" name="author" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="genre">Genre:</label>
                <input type="text" name="genre" class="form-control" required>
            </div>
            <button type="submit" class="form-btn" name="add_book">Add Book</button>
        </form>

        <!-- Add any additional content or features you want to display on the page -->

    </div><!-- End container -->

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
