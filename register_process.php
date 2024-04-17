<?php
session_start();
include ("dbconn.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST['confirmPassword'];

    $checkQuery = "SELECT email FROM user WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $_SESSION['error_message'] = "Email already exist. Pick another.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();

    } else if ($password != $confirm_password) {

        $_SESSION['error_message'] = "Password does not match. Try again.";
        header("Location: register.php");
        exit();

    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $role = "user";
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fName, $lName, $email, $hashedPassword, $role);
        $result = $stmt->execute();

        if ($result) {

            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
            unset($_SESSION['email']);
            unset($_SESSION['error']);
            header("Location: login.php");
            exit();
        } else {
            header("Location: register.php?error=Invalid email or password");
            exit();
        }

    }
}
?>