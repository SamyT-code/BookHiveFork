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

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the new first name and last name from the form
    $newFirstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $newLastName = mysqli_real_escape_string($conn, $_POST['last_name']);

    // Check if there are changes to the first name or last name
    if ($newFirstName !== $firstName || $newLastName !== $lastName) {
        // Perform an update query to update the first name and last name in the database
        $updateQuery = "UPDATE Members SET first_name='$newFirstName', last_name='$newLastName' WHERE email='$email'";
        if (mysqli_query($conn, $updateQuery)) {
            // Update successful, refresh the page to show the updated information
            header("Refresh:0");
        } else {
            // Handle error if the update fails
            $errorMessage = "Failed to update profile. Please try again later.";
        }
    }
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
    <title>Student Profile</title>
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
        include_once 'student_navbar.php'; // Code to add navbar
    ?>

        <header>
            <h1>Welcome <?php echo htmlspecialchars($firstName . "!"); ?></h1>
        </header>

        <header>
            <h2>Buzz into Knowledge: Unleash Your Inner Bookworm!</h2>
        </header>

        <div class="container">
            <!-- Profile Form -->
            <header>
                <h1>Profile</h1>
            </header>
            <form action="profile.php" method="POST" onsubmit="return confirmUpdate()">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($firstName); ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo htmlspecialchars($lastName); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
            <?php
            if (isset($errorMessage)) {
                echo '<p class="error-message">' . $errorMessage . '</p>';
            }
            ?>

            <!-- JavaScript to confirm update -->
            <script>
                function confirmUpdate() {
                    const oldFirstName = '<?php echo $firstName; ?>';
                    const oldLastName = '<?php echo $lastName; ?>';
                    const newFirstName = document.getElementById('first_name').value;
                    const newLastName = document.getElementById('last_name').value;

                    if (oldFirstName === newFirstName && oldLastName === newLastName) {
                        // No changes made, show alert and prevent form submission
                        alert('No changes were made.');
                        return false;
                    }

                    // Show confirmation box with old and new information
                    const confirmationText = `
                        Old First Name: ${oldFirstName}
                        Old Last Name: ${oldLastName}
                        New First Name: ${newFirstName}
                        New Last Name: ${newLastName}
                    `;

                    return confirm(confirmationText);
                }
            </script>

            <!-- ... remaining code ... -->
        </div>
    </div>
</body>
</html>
