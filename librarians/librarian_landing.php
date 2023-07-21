<?php
session_start(); // Start the session

include_once '../db.php'; // Code to connect to the database, initializes $conn

// Check if the librarian is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the librarian is not logged in
    header('Location: librarian_login.php');
    exit();
}

// Retrieve the librarian's information from session variables
$email = $_SESSION['email'];

// Perform a query to fetch first and last name from the Members table
$query = "SELECT first_name, last_name FROM Librarians WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];
} else {
    // Handle error if the user information is not found
    $firstName = "Unknown";
    $lastName = "User";
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>librarian Landing</title>
    <link rel="icon" type="image/x-icon" href="../images/bee.png">
    <link rel="stylesheet" href="../css/main.css" /> <!-- Path references upper/css to use css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/landing.css" />
    <link rel="stylesheet" href="../css/student_landing.css" />
</head>
<body>

    <!-- Logout Button START -->
    <div class="container">
    <div class="logout-btn">
        <a href="../logout.php" class="logout-btn-text">Logout</a>
    </div><!-- Logout Button END -->

        <!-- Welcome Message -->
        <header>
            <h1>Welcome <?php echo htmlspecialchars($firstName . "!"); ?></h1>
            <h2>This is where you will manage the Bookhive!</h2>
        </header>

        <!-- Navigation Menu -->
        <nav>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="librarian_return.php" style="font-size: 24px;">Return Books</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="librarian_add.php" style="font-size: 24px;">Add Books</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="librarian_delete.php" style="font-size: 24px;">Delete Books</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="librarian_add_student.php" style="font-size: 24px;">Add Student</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Add your librarian landing page content here -->
    

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
