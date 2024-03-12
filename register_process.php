<?php
session_start();
include("dbconn.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST['confirmPassword'];

    if ($password != $confirm_password) {


        header("Location: register.php");
        exit();

    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $role = "user";
        $query = "INSERT INTO user (first_name, last_name, email, password, role) VALUES ('$fName', '$lName', '$email', '$hashedPassword', '$role')";
        $result = mysqli_query($conn, $query);

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