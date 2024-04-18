<?php
session_start();
include ("dbconn.php");


if ($_SESSION['user_role'] !== 'user') {

    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM user_resumes WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>