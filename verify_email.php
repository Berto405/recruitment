<?php
session_start();
include ('dbconn.php');

if (isset($_GET["token"])) {

    $token = $_GET["token"];

    $verifyQuery = "SELECT verify_token, verify_status FROM user WHERE verify_token = ? LIMIT 1";
    $stmt = $conn->prepare($verifyQuery);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch a row as an associative array

        if ($row['verify_status'] == "0") {
            $clickedToken = $row['verify_token'];
            $status = 1;

            $updateQuery = "UPDATE user SET verify_status = ? WHERE verify_token = ? LIMIT 1";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("is", $status, $clickedToken);
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                $_SESSION['success_message'] = "Your account has been verified.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Verificaiton Failed.";
                header("Location: login.php");
                exit();
            }


        } else {
            $_SESSION['error_message'] = "This email is already verified. Please login.";
            header("Location: login.php");
            exit();
        }

    } else {
        $_SESSION['error_message'] = "Token does not exist.";
        header("Location: login.php");
        exit();
    }

} else {
    $_SESSION['error_message'] = "Not allowed";
    header("Location: login.php");
    exit();
}
?>