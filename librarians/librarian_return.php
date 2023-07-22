<?php
// Start the session and include the database connection
session_start();
include_once '../db.php';

// Function to sanitize input data to prevent SQL injection
function sanitize($data) {
    global $conn; // Make $conn variable available inside the function
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

// Check if the librarian is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the librarian is not logged in
    header('Location: librarian_login.php');
    exit();
}

// Step 2: Perform a query to get all books from the Books table
$sql = "SELECT * FROM Books";
$result = mysqli_query($conn, $sql); // Execute the query to get all books

// Check if the librarian applied any filters
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

// Function to display applied filters
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

// Function to change the status of a book from checked out to available
function changeStatusToAvailable($book_id) {
    global $conn;

    $update_query = "UPDATE Books SET checked_out_by = -1 WHERE book_id = $book_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo '<div class="alert alert-success" role="alert">Book status changed to Available.</div>';
        header('Location: librarian_return.php');
    } else {
        echo '<div class="alert alert-danger" role="alert">Error changing book status. Please try again later.</div>';
    }
}

// Check if the user clicked the "Change Status to Available" button
if (isset($_POST['change_status'])) {
    $book_id = $_POST['book_id'];
    changeStatusToAvailable($book_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Books</title>
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
        
        <h1 style="font-weight: bold">Return Books</h1>

        <!-- Search Bar -->
        <form class="form-inline" action="librarian_return.php" method="GET">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search by author, title, or description" size="50">
            </div>
            <button type="submit" class="form-btn">Search</button>
        </form>

        <!-- Filter Options -->
        <div class="announce-div">
            <h2>Filter Options:</h2>
            <form action="librarian_return.php" method="GET">
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

                <button type="submit" class="filter-btn">Apply Filters</button>
            </form>
        </div>

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
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="panel panel-default">';
                echo '<div class="panel-heading">' . $row['title'] . '</div>';
                echo '<div class="panel-body">';
                echo '<p><strong>Author:</strong> ' . $row['author'] . '<br>';
                echo '<strong>Description:</strong> ' . $row['description'] . '<br>';
                
                // Display Change Status button for checked out books
                if ($row['checked_out_by'] !== '-1') {
                    // Get the name of the student who has the book
                    $student_id = $row['checked_out_by'];
                    $student_query = "SELECT first_name, last_name FROM Members WHERE member_id = $student_id";
                    $student_result = mysqli_query($conn, $student_query);
                    $student_row = mysqli_fetch_assoc($student_result);
                    $student_name = $student_row['first_name'] . ' ' . $student_row['last_name'];

                    echo '<strong>Checked Out By:</strong> ' . $student_name . '<br>';
                    echo '<strong>Availability:</strong> Checked Out</p>';
                    // Add a button to change the status to Available
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="book_id" value="' . $row['book_id'] . '">';
                    echo '<button type="submit" class="btn btn-success" name="change_status">Change Status to Available</button>';
                    echo '</form>';
                } else {
                    echo '<strong>Availability:</strong> Available</p>';
                }
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-info" role="alert">No books found.</div>';
        }
        ?>

        <!-- Add any additional content or features you want to display on the page -->

    </div><!-- End container -->

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
