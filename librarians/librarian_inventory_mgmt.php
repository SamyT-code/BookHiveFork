<?php
session_start(); // Start the session
include_once '../db.php'; // Code to connect to the databse, initializes $conn

// Check if the librarian is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the librarian is not logged in
    header('Location: librarian_login.php');
    exit();
}

// add PHP

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
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
                <li><a href="librarian_landing.php">Librarian Home</a></li>
                <li><a href="librarian_inventory_mgmt.php">Manage Inventory</a></li>
                <li><a href="librarian_checkout.php">Checked Out Items</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h3 class="welcome-message">View and manage library inventory</h3>

        <h3 class="welcome-message">[table goes here]</h3>
    </div>

    <footer>
        <p>&copy; 2023 Bookhive. All rights reserved.</p>
    </footer>
</body>
</html>
