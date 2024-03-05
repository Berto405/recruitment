<?php
session_start();

// Check if user is not logged in and has a role
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    // Redirect users who are not logged in to the login page
    header("Location: /recruitment/index.php");
    exit();
}
?>