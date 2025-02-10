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

?>

<!DOCTYPE html>
<html>

<head>
    <title>Book Recommender</title>
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
        <div class="announce-div">
            <h1>Let's Unveil Today's Read</h1>
        </div>

        <h2>Get personalized recommendations, just by entering your thought of the day!</h2><br>
        <form class="form-inline" action="recommendations.php" method="POST">
            <div class="form-group">
                <textarea name="thoughts" rows="4" cols="100"
                    placeholder="Describe yourself, your thoughts or anything you find interesting at the moment"></textarea>
            </div>
            <button type="submit" class="form-btn">Search</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Retrieve the user's thoughts from the form
            if (isset($_POST["thoughts"])) {
                $userThoughts = $_POST["thoughts"];
                if (!empty($userThoughts)) {

                    $a = escapeshellcmd('python auto-categorization.py "' . $userThoughts . '"');
                    $output = shell_exec($a); // Calling the Python NLP script

                    if ($output === null || empty($output)) {
                        $output = "Unknown"; // Default category if the script fails
                    }

                    // Display user-friendly message if recommendations are unavailable
                    if ($output === "Unknown") {
                        echo "<h3>Personalized Recommendations</h3>";
                        echo "<p>Your thoughts: " . htmlspecialchars($userThoughts) . "</p>";
                        echo "<p>Unfortunately, our recommendation system is currently unavailable.</p>";
                        echo "<p>You can view a demo of this project here: 
          <a href='https://uottawa-my.sharepoint.com/personal/kzahr091_uottawa_ca/_layouts/15/guestaccess.aspx?share=Ebkgp4FNks5OgQsy-iVQA8YBbNZyhfWJ3gn3j0PLlIrCOg' target='_blank'>
          Click here to see the demo</a>.</p>";
                    }


                    $sql = "SELECT * FROM Books WHERE genre LIKE '%$output%'";
                    $result = mysqli_query($conn, $sql);

                    // Display the personalized recommendations
                    echo "<h3><br><br>Personalized Recommendations</h3>";
                    echo "<p>Your thoughts: " . htmlspecialchars($userThoughts) . "</p>";
                    echo "<p>Here are some personalized recommendations based on your thoughts:</p>";

                    displayBooks($result);
                }
            }
        }

        function displayBooks($result)
        {
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
        // Check if the user clicked the checkout button
        if (isset($_POST['checkout'])) {
            echo "<br><br><br><h2>Great choice! Please go to the front desk to check this book out.</h2>";
            // $book_id = $_POST['book_id'];
            // // $user_id = $_SESSION['member_id'];
            // checkoutBook($book_id, $user_id);
        }
        // Function to check out a book
        function checkoutBook($book_id, $user_id)
        {
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
        ?>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>