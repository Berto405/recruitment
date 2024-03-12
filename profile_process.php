<?php
session_start();
include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get the currently logged in user's id
    $userId = $_SESSION["user_id"];

    //FOR EDITING PROFILE
    $newFName = $_POST['newFName'];
    $newLName = $_POST['newLName'];
    $newEmail = $_POST['newEmail'];

    if ($userId) {
        $query =
            "UPDATE user 
            SET first_name = '$newFName', 
            last_name = '$newLName', email = '$newEmail' 
            WHERE id = '$userId'";
        $result = mysqli_query($conn, $query);

        $_SESSION['success_message'] = "Profile Updated";
        //Change name on header
        $_SESSION['user_name'] = $newFName . ' ' . $newLName;

        header("Location: profile.php");
        exit();
    }
    //FOR CHANGING PASSWORD
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];



    $passwordQuery = "SELECT password FROM user WHERE id = '$userId'";
    $passwordResult = mysqli_query($conn, $passwordQuery);
    $passRow = mysqli_fetch_assoc($passwordResult);
    $hashedPassword = $passRow['password'];

    if (password_verify($currentPassword, $hashedPassword)) {

        if ($newPassword !== $confirmNewPassword) {
            $_SESSION["error_message"] = "Password do not match";
            header("Location: profile.php");
            exit();
        } else {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE user SET password = '$hashedNewPassword' WHERE id = '$userId'";

            if (mysqli_query($conn, $updateQuery)) {

                $_SESSION["success_message"] = "Changed Password";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION["error_message"] = "Invalid Input";
                header("Location: profile.php");
                exit();
            }
        }
    } else {
        $_SESSION["error_message"] = "Current Password is Incorrect";
        header("Location: profile.php");
        exit();
    }
}

?>