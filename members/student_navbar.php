<br><br>
<!-- Bootstrap Navbar -->
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Navbar header with logo or title -->
        <div class="navbar-header">
            <a class="navbar-brand" href="student_landing.php" style="padding: 0;">
                <img src="../images/bee.png" alt="Logo" height="50">
            </a>
        </div>

        <!-- Navbar links -->
        <ul class="nav navbar-nav">
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'profile.php') !== false) echo 'class="active"'; ?>><a href="profile.php">Profile</a></li>
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'mybooks.php') !== false) echo 'class="active"'; ?>><a href="mybooks.php">My Books</a></li>
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'searchbooks.php') !== false) echo 'class="active"'; ?>><a href="searchbooks.php">Search & Checkout Books</a></li>
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'recommendations.php') !== false) echo 'class="active"'; ?>><a href="recommendations.php">Recommendations</a></li>
        </ul>

       
    </div>
</nav>
