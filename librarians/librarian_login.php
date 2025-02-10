<?php
session_start(); // Start the session

include_once '../db.php'; // Code to connect to the databse, initializes $conn

// Initialize variables
$email = $password = $msg = $err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Perform a query to check if the user exists
    $query = "SELECT * FROM Librarians WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        // Login successful
        $_SESSION['email'] = $email; // Set email in the session
        header('Location: librarian_landing.php'); // Redirect to librarian landing page
        exit();
    } else {
        // Login failed
        $err = "Invalid email or password. Please try again.";
    }

    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Login</title>
    <link rel="icon" type="image/x-icon" href="../images/bee.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>

<body>
    <div class="container bootstrap snippets bootdey">
        <br>
        <header class="sign-in-header">Bookhive</header>
        <br>
        <h2>
            <img src="../images/bee.png" alt="Logo" height="60" style="margin-right: 10px"> Enter Librarian Login
            Details
        </h2>
        <h3 class="error"><?php echo $err; ?></h3>
        <h4 class="form-signin-heading"><?php echo $msg; ?></h4>

        <form class="form-signin" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
            method="post">
            <h4>Email</h4>
            <input type="email" class="form-control" name="email"
                placeholder="Enter email (ex: ethan.smith@bookhive.com)" maxlength="255" required>
            <span class="error"> * <?php echo $email == "" ? 'Email is required!' : ''; ?> </span><br><br>

            <h4>Password</h4>
            <input type="password" class="form-control" name="password" placeholder="Enter password (ex: securepass123)"
                maxlength="255" required>
            <span class="error"> * <?php echo $password == "" ? 'Password is required!' : ''; ?> </span><br>

            <br><br>
            <div><button class="btn" type="submit" name="login">Login</button></div>
        </form>
    </div>

</body>
<script>
// this if statement turns off the "Confirm Form Resubmission" and prevents multiple form submissions
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>

</html>