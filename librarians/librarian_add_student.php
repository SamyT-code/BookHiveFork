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
if (isset($_POST['add_user'])) {
    // Retrieve and sanitize form data
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Perform a query to check if the email already exists
    $check_query = "SELECT * FROM Members WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        // Email does not exist, proceed to add the user account
        if ($password === $confirm_password) {
            $insert_query = "INSERT INTO Members (first_name, last_name, email, password)
                             VALUES ('$first_name', '$last_name', '$email', '$password')";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                echo '<div class="alert alert-success" role="alert">Student user account added successfully.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error adding student user account. Please try again later.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Passwords do not match. Please re-enter your password.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Student user account with the same email already exists.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student Account</title>
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
            // Include the librarian navbar
            include_once 'librarian_navbar.php';
        ?>

        <h1>Add Student Account</h1>

        <!-- Student Account Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_user">Add User</button>
        </form>

        <!-- Add any additional content or features you want to display on the page -->

    </div><!-- End container -->

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
