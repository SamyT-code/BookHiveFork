<br><br>
<!-- Bootstrap Navbar -->
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Navbar header with logo or title -->
        <div class="navbar-header">
            <a class="navbar-brand" href="librarian_landing.php" style="padding: 0;">
                <img src="../images/bee.png" alt="Logo" height="50">
            </a>
        </div>

        <!-- Navbar links -->
        <ul class="nav navbar-nav">
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'librarian_return.php') !== false) echo 'class="active"'; ?>><a href="librarian_return.php">Return Books</a></li>
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'librarian_add.php') !== false) echo 'class="active"'; ?>><a href="librarian_add.php">Add Books</a></li>
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'librarian_delete.php') !== false) echo 'class="active"'; ?>><a href="librarian_delete.php">Delete Books</a></li>
            <li <?php if (strpos($_SERVER['REQUEST_URI'], 'librarian_add_student.php') !== false) echo 'class="active"'; ?>><a href="librarian_add_student.php">Add Student Account</a></li>
        </ul>

       
    </div>
</nav>
