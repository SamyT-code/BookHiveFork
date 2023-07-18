<?php
session_start(); // Start the session

include_once '../db.php'; // Code to connect to the databse, initializes $conn

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
    <link rel="icon" type="image/x-icon" href="images/bee.png">
    <link rel="stylesheet" href="../css/main.css" /> <!-- Path references upper/css to use css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/landing.css" />
</head>
<body>
    <!-- Logout Button START -->
    <div class="container">
        <div class="logout-btn">
            <a href="logout.php" class="logout-btn-text">Logout</a>
        </div><!-- Logout Button END -->
        <header>
            <h1>Welcome, student <?php echo htmlspecialchars($firstName . " " . $lastName); ?></h1>
        </header>

        <header>
            <h2>Buzz into Knowledge: Unleash Your Inner Bookworm!</h2>
        </header>

        <nav>
            <header>
                <h3><a href="#">Home</a></h3>
            </header>
            <header>
                <h3><a href="#">Profile</a></h3>
            </header>
            <header>
                <h3><a href="#">Books</a></h3>
            </header>
            <header>
                <h3><a href="#">Reccommendations</a></h3>
            </header>
        </nav>

        <div class="container">
            <!-- Add your student landing page content here -->
        </div>
    </div>
</body>
</html>

