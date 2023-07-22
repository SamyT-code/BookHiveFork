<?php
session_start(); // Start the session

include_once '../db.php'; // Code to connect to the database, initializes $conn

// Check if the student is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the student is not logged in
    header('Location: student_login.php');
    exit();
}

// Retrieve the student's information from session variables
$email = $_SESSION['email'];

// Perform a query to fetch first and last name from the Members table
$query = "SELECT first_name, last_name FROM Members WHERE email='$email'";
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
    <title>Student Landing</title>
    <link rel="icon" type="image/x-icon" href="../images/bee.png">
    <link rel="stylesheet" href="../css/main.css" /> <!-- Path references upper/css to use css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/landing.css" />
    <link rel="stylesheet" href="../css/student_landing.css" />
    <link rel="stylesheet" href="../css/styles.css" />
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
            <h2>Buzz into Knowledge: Unleash Your Inner Bookworm!</h2>
        </header>

        <!-- Navigation Menu -->
        <nav>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="profile.php" style="font-size: 24px;">Profile</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="mybooks.php" style="font-size: 24px;">My Books</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="searchbooks.php" style="font-size: 24px;">Search & Checkout Books</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card-option">
                        <a href="recommendations.php" style="font-size: 24px;">Recommendations</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Add your student landing page content here -->
    

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
