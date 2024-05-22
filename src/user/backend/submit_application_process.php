<?php
session_start();
include ('dbconn.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: /recruitment/login');
    exit();
} else if ($_SESSION['user_role'] !== 'user') {

    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: /recruitment/home");
    exit();
} else {
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM user_resumes WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $query);
    $resumeResult = mysqli_fetch_array($result);


}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submitApplicationBtn'])) {
        submitApplication($conn, $userId, $applicationCount);
    }
}


function submitApplication($conn, $userId, $applicationCount)
{
    //Checks if user already submitted
    $applicationQuery = "SELECT * FROM job_applicants WHERE user_id = ?";
    $applicationStmt = $conn->prepare($applicationQuery);
    $applicationStmt->bind_param("i", $userId);
    $applicationStmt->execute();
    $applicationResult = $applicationStmt->get_result();
    $applicationCount = $applicationResult->num_rows;

    if ($applicationCount == 0) {
        $query = "INSERT INTO job_applicants (user_id, application_status) VALUES (?, ?)";
        $status = "Pooling";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $userId, $status);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION["success_message"] = "Application Submitted";
        } else {
            $_SESSION["error_message"] = "Application Failed. Try Again";
        }
    } else {
        $_SESSION["error_message"] = "You have already submitted an application.";
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>