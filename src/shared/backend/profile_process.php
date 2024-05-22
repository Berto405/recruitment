<?php
session_start();
include ("dbconn.php");

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM user WHERE id = '$userId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
} else {
    header("Location: /recruitment/login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get the currently logged in user's id
    $userId = $_SESSION["user_id"];

    //FOR EDITING PROFILE
    $newFName = $_POST['newFName'];
    $newLName = $_POST['newLName'];
    $newEmail = $_POST['newEmail'];

    if (isset($_POST['editProfileButton'])) {
        if ($userId) {
            $query =
                "UPDATE user 
            SET first_name = ?, 
            last_name =?, 
            email = ?
            WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $newFName, $newLName, $newEmail, $userId);
            $stmt->execute();

            $_SESSION['success_message'] = "Profile Updated";
            //Change name on header
            $_SESSION['user_name'] = $newFName . ' ' . $newLName;

            header("Location: profile.php");
            exit();
        }
    }

    if (isset($_POST["changePassButton"])) {
        //FOR CHANGING PASSWORD
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        $passwordQuery = "SELECT password FROM user WHERE id = ?";
        $stmt = $conn->prepare($passwordQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $passRow = $result->fetch_assoc();
            $hashedPassword = $passRow['password'];

            if (password_verify($currentPassword, $hashedPassword)) {

                if ($newPassword !== $confirmNewPassword) {
                    $_SESSION["error_message"] = "Password do not match";
                    header("Location: profile.php");
                    exit();
                } else {
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateQuery = "UPDATE user SET password = ? WHERE id = ?";
                    $stmt = $conn->prepare($updateQuery);
                    $stmt->bind_param("si", $hashedNewPassword, $userId);
                    $stmt->execute();


                    if ($stmt->affected_rows > 0) {

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
        } else {
            $_SESSION["error_message"] = "User not found";
        }
    }
}

?>