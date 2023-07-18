<?php
session_start(); // Start the session
include_once '../db.php'; // Code to connect to the databse, initializes $conn

// Check if the librarian is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the librarian is not logged in
    header('Location: librarian_login.php');
    exit();
}

// Retrieve the librarian's information from session variables
$email = $_SESSION['email'];

// Perform a query to fetch first and last name from the Librarians table
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
    <title>Librarian Landing</title>
    <link rel="icon" type="image/x-icon" href="images/bee.png">
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/main.css" />
</head>

<body>
    <header>
        <h1>Bookhive</h1>
        <nav>
            <ul>
                <li>
                    <!-- Logout Button START -->
                    <div class="container">
                        <div class="logout-btn">
                            <a href="../logout.php" class="logout-btn-text">Logout</a>
                        </div>
                    </div>
                    <!-- Logout Button END -->
                </li>
                <li><a href="librarian_inventory_mgmt.php">Manage Inventory</a></li>
                <li><a href="librarian_checkout.php">Checked Out Items</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h3 class="welcome-message"> Welcome, librarian <?php echo htmlspecialchars($firstName . " " . $lastName); ?></h3>
        
        
    </div>

    <footer>
        <p>&copy; 2023 Bookhive. All rights reserved.</p>
    </footer>
</body>
</html>
