<?php
session_start();
include ("../dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset ($_POST['addUserBtn'])) {
        addUser($conn);
    }
}

//FUNCTIONS HERE


function addUser($conn)
{
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST["email"];
    $branch = $_POST["branch"];
    $password = $_POST["password"];
    $confirm_password = $_POST['confirmPass'];

    if ($password != $confirm_password) {

        header("Location: ../admin/manage_user.php");
        exit();

    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $role = "admin";
        $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, role, branch) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fName, $lName, $email, $hashedPassword, $role, $branch);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Added User.";
            header("Location: ../admin/manage_user.php");
            exit();
        } else {
            $_SESSION['errror_message'] = "Failed to Add User.";
            header("Location: ../admin/manage_user.php");
            exit();
        }

    }

}
?>