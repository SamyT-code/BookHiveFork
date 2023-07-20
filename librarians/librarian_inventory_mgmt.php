<?php
session_start(); // Start the session
include_once '../db.php'; // Code to connect to the databse, initializes $conn

// Check if the librarian is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if the librarian is not logged in
    header('Location: librarian_login.php');
    exit();
}

// retrieve all books and display in table
$email = $_SESSION['email'];

// Perform a query to fetch librarian_id from the Librarians table
$query = "SELECT librarian_id FROM Librarians WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['librarian_id'];
}

$sql = "SELECT * FROM Books";
$result = $conn->query($sql);

// add book feature (one by one)

// remove book feature (one by one) thinking to do a remove button in each table row

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
    <link rel="stylesheet" href="../css/tables.css" />
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

    <div>
        <h3 class="welcome-message">View and manage library inventory</h3>

        <table>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Remove</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['book_id'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['author'] . "</td>";
                echo "<td>" . $row['genre'] . "</td>";
                echo "<td><button class='remove-btn'>x</button></td></tr>";
            }
            ?>
            
        </table>
    </div>

    <footer>
        <p>&copy; 2023 Bookhive. All rights reserved.</p>
    </footer>
</body>
</html>
