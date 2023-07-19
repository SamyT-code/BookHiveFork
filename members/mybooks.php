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
</head>
<body>
    <h1>My Books</h1>
    <?php
    if ($number_of_books > 0) {
        echo "<p>You have $number_of_books book(s) checked out:</p>";
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Title:</strong> " . $row['title'] . "<br>";
            echo "<strong>Author:</strong> " . $row['author'] . "<br>";
            echo "<strong>Genre:</strong> " . $row['genre'] . "<br>";
            echo "<strong>Description:</strong> " . $row['description'] . "</p>";
        }
    } else {
        echo "<p>You have no books checked out.</p>";
    }

    echo "<p>You can check out up to $max_books books. You have $remaining_slots slot(s) remaining.</p>";
    ?>

    <!-- Add any additional content or features you want to display on the landing page -->

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
