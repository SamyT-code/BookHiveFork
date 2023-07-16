<?php
session_start(); // Start the session

include_once 'db.php'; // Code to connect to the databse, initializes $conn

// Initialize variables
$email = $password = $msg = $err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Perform a query to check if the user exists
    $query = "SELECT * FROM members WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        // Login successful
        $_SESSION['email'] = $email; // Set email in the session
        header('Location: student_landing.php'); // Redirect to student landing page
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
    <title>Student Login</title>
    <link rel="icon" type="image/x-icon" href="images/bee.png">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css" />
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/excite-bike/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="scripts/lms.js"></script>
    <script>
        $(document).ready(function(){
            $("#toggle").click(function(){
                $("#accounts").fadeToggle();
            });
        });
    </script>
</head>

<body>

    <div class="container bootstrap snippets bootdey">
        <br>
        <h1 class="bio-graph-heading dcms-header" style="font-size: 30px;">Bookhive</h1>
        <br>
        <h2>Enter Student Login Details</h2>
        <h3 class="error"><?php echo $err; ?></h3>
        <h4 class="form-signin-heading"><?php echo $msg; ?></h4>

        <form class="form-signin" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h4>Email</h4>
            <input type="email" class="form-control" name="email" placeholder="Enter email" maxlength="255" required>
            <span class="error"> * <?php echo $email == "" ? 'Email is required!' : ''; ?> </span><br>
            
            <h4>Password</h4>
            <input type="password" class="form-control" name="password" placeholder="Enter password" maxlength="255" required>
            <span class="error"> * <?php echo $password == "" ? 'Password is required!' : ''; ?> </span><br>

            <br><br>
            <button class="btn btn-lg btn-primary btn-block btn-warning" type="submit" name="login">Login</button>
        </form>

        <h2> No Account? <a href="register.php">Register here! </a> </h2> <br>  

    </div>

</body>
<script>
    // this if statement turns off the "Confirm Form Resubmission" and prevents multiple form submissions
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</html>
