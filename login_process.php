<?php
session_start();
include ("dbconn.php");


$email = $_POST["email"];
$password = $_POST["password"];

$query = "SELECT * FROM user WHERE email=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_role'] = $row['role'];
        $_SESSION['user_resume'] = $row['resume'];

        // Redirect based on user role
        if ($_SESSION['user_role'] === 'admin') {
            header("Location: /recruitment/admin/home.php");
            exit();
        } else {
            header("Location: /recruitment/index.php");
            exit();
        }
    } else {
        header("Location: login.php?error=Wrong email or passworsd");
        exit();
    }
} else {
    header("Location: login.php?error=Wrong email or password");
    exit();
}
?>