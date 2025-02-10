<?php
// Ensure session is started before doing anything
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: index.html");
exit; // Ensure script stops execution after redirection