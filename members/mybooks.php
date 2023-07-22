<?php
session_start(); // Start the session

include_once '../db.php'; // Code to connect to the database, initializes $conn

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

$sql = "SELECT * FROM Books WHERE checked_out_by = $user_id";
$result = $conn->query($sql);

// Count how many books the user has
$number_of_books = $result->num_rows;

// Calculate how many more books the user can check out (up to a maximum of 4)
$max_books = 4;
$remaining_slots = $max_books - $number_of_books;

// Step 3: Display the books and the available slots
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Books</title>
    <link rel="icon" type="image/x-icon" href="../images/bee.png">
    <link rel="stylesheet" href="../css/main.css" /> <!-- Path references upper/css to use css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/mybooks.css" />
</head>
<body style="background-color: #b6d0c7">
    <!-- Logout Button START -->
    <div class="container">
    <div class="logout-btn">
        <a href="../logout.php" class="logout-btn-text">Logout</a>
    </div><!-- Logout Button END -->
    <?php
        include_once 'student_navbar.php'; // Code to add navbar
    ?>
    <div class="container">
        <h1 style="font-weight: bold">My Books</h1>
        <?php
        if ($number_of_books > 0) {
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-sm-6">';
                echo '<div class="book-card" style="background-color: #fff">';
                echo '<p><strong>Title:</strong> ' . $row['title'] . '</p>';
                echo '<p><strong>Author:</strong> ' . $row['author'] . '</p>';
                echo '<p><strong>Genre:</strong> ' . $row['genre'] . '</p>';
                echo '<p><strong>Description:</strong> ' . $row['description'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>You have no books checked out.</p>';
        }

        echo '<div class="available-books">';
        echo "<p>You can check out up to $max_books books. You have $remaining_slots book(s) remaining.</p>";
        echo "<p>To return a book, simply hand it over to a librarian and he or she will mark it as returned :)</p>";
        echo '</div>';
        ?>

        <!-- Add any additional content or features you want to display on the landing page -->

    </div><!-- .container -->

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
