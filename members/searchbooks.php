<?php
// Start the session and include the database connection
session_start();
include_once '../db.php';

// Check if the student is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the student is not logged in
    header('Location: student_login.php');
    exit();
}

// Step 2: Retrieve user's books
$email = $_SESSION['email'];

// Perform a query to fetch member_id from the Members table
$query = "SELECT member_id FROM Members WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['member_id'];
}

// Function to sanitize input data to prevent SQL injection
function sanitize($data) {
    global $conn; // Make $conn variable available inside the function
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

// Perform a query to get all books from the Books table
$sql = "SELECT * FROM Books";
$result = mysqli_query($conn, $sql);

// Check if the user has submitted a search query or filters
if (isset($_GET['search'])) {
    $search = sanitize($_GET['search']);
    // Perform a query with search filter
    $sql = "SELECT * FROM Books 
            WHERE author LIKE '%$search%' OR title LIKE '%$search%' OR description LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
} else if (isset($_GET['author']) || isset($_GET['availability']) || isset($_GET['title'])) {
    $author = sanitize($_GET['author']);
    $availability = sanitize($_GET['availability']);
    $title = sanitize($_GET['title']);

    // Perform a query with filter options
    $sql = "SELECT * FROM Books WHERE 1=1"; // Start with a true condition

    if (!empty($author)) {
        $sql .= " AND author LIKE '%$author%'";
    }

    if ($availability === "available") {
        $sql .= " AND checked_out_by = -1";
    } elseif ($availability === "checked_out") {
        $sql .= " AND checked_out_by >= 1";
    }

    if (!empty($title)) {
        $sql .= " AND title LIKE '%$title%'";
    }

    $result = mysqli_query($conn, $sql);
}

// Function to display the books
function displayBooks($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="panel panel-default">';
            echo '<div class="panel-heading">' . $row['title'] . '</div>';
            echo '<div class="panel-body">';
            echo '<p><strong>Author:</strong> ' . $row['author'] . '<br>';
            echo '<strong>Description:</strong> ' . $row['description'] . '<br>';
            
            // Display availability status based on checked_out_by value
            if ($row['checked_out_by'] === '-1') {
                echo '<strong>Availability:</strong> Available</p>';
                // Add a button to check out the book
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="book_id" value="' . $row['book_id'] . '">';
                echo '<button type="submit" class="btn btn-primary" name="checkout">Check Out</button>';
                echo '</form>';
            } else {
                echo '<strong>Availability:</strong> Checked Out</p>';
            }
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="alert alert-info" role="alert">No books found.</div>';
    }
}

// Function to display the currently applied filters
function displayAppliedFilters($author, $availability, $title) {
    echo '<div class="panel panel-info">';
    echo '<div class="panel-heading">Applied Filters:</div>';
    echo '<div class="panel-body">';

    // Display Filter by Author
    if (!empty($author)) {
        echo '<p><strong>Filter by Author:</strong> ' . $author . '</p>';
    }

    // Display Filter by Availability
    if (!empty($availability)) {
        if ($availability === "available") {
            echo '<p><strong>Filter by Availability:</strong> Available</p>';
        } elseif ($availability === "checked_out") {
            echo '<p><strong>Filter by Availability:</strong> Checked Out</p>';
        }
    }

    // Display Filter by Title
    if (!empty($title)) {
        echo '<p><strong>Filter by Title:</strong> ' . $title . '</p>';
    }

    echo '</div>';
    echo '</div>';
}

// Function to check out a book
function checkoutBook($book_id, $user_id) {
    global $conn;

    // Check if the user has less than four books checked out
    $count_query = "SELECT COUNT(*) as count FROM Books WHERE checked_out_by = $user_id";
    $count_result = mysqli_query($conn, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $num_books_checked_out = $count_row['count'];

    if ($num_books_checked_out < 4) {
        // Update the checked_out_by attribute to the user_id
        $update_query = "UPDATE Books SET checked_out_by = $user_id WHERE book_id = $book_id";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo '<div class="alert alert-success" role="alert">Book has been checked out successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error checking out the book. Please try again later.</div>';
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">You can only check out up to 4 books at a time. Please return a book before checking out a new one.</div>';
    }
}

// Check if the user clicked the checkout button
if (isset($_POST['checkout'])) {
    $book_id = $_POST['book_id'];
    // $user_id = $_SESSION['member_id'];
    checkoutBook($book_id, $user_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Books</title>
    <link rel="icon" type="image/x-icon" href="../images/bee.png">
    <link rel="stylesheet" href="../css/main.css" /> <!-- Path references upper/css to use css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/landing.css" />
</head>
<body>
    <!-- Logout Button START -->
    <div class="container">
    <div class="logout-btn">
        <a href="../logout.php" class="logout-btn-text">Logout</a>
    </div><!-- Logout Button END -->
    <?php
        include_once 'student_navbar.php'; // Code to add navbar
    ?>
    
    <h1>Search Books</h1>

    <!-- Search Bar -->
    <form class="form-inline" action="searchbooks.php" method="GET">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Search by author, title, or description" size="50">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Filter Options -->
    <h2>Filter Options:</h2>
    <form action="searchbooks.php" method="GET">
        <!-- Filter by Title -->
        <div class="form-group">
            <label for="title">Filter by Title:</label>
            <input type="text" name="title" class="form-control" placeholder="Book title">
        </div>

        <!-- Filter by Author -->
        <div class="form-group">
            <label for="author">Filter by Author:</label>
            <input type="text" name="author" class="form-control" placeholder="Author's name">
        </div>

        <!-- Filter by Availability -->
        <div class="form-group">
            <label for="availability">Filter by Availability:</label>
            <select name="availability" class="form-control">
                <option value="">All Books</option>
                <option value="available">Available</option>
                <option value="checked_out">Checked Out</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Apply Filters</button>
    </form>

    <!-- Display Applied Filters -->
    <?php
    // Check if any filters are applied
    if (isset($_GET['author']) || isset($_GET['availability']) || isset($_GET['title'])) {
        $author = sanitize($_GET['author']);
        $availability = sanitize($_GET['availability']);
        $title = sanitize($_GET['title']);

        // Call the function to display the currently applied filters
        displayAppliedFilters($author, $availability, $title);
    }
    ?>

    <!-- Display Books -->
    <h2>All Books:</h2>
    <?php
    // Call the function to display the books
    displayBooks($result);
    ?>

    <!-- Add any additional content or features you want to display on the page -->

</body>
</html>
