<?php
session_start();
include ("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['job_id'])) {
        $jobId = $_POST['job_id'];
        $userId = $_SESSION['user_id'];

        // Check if user has already applied for the specific job
        $checkQuery = "SELECT * FROM job_applicants WHERE user_id = ? AND job_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ii", $userId, $jobId);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        $query3 = "SELECT * FROM job_applicants WHERE user_id = ? LIMIT 1";
        $stmt3 = $conn->prepare($query3);
        $stmt3->bind_param("i", $userId);
        $stmt3->execute();
        $result3 = $stmt3->get_result();


        if ($checkResult->num_rows > 0) {
            // User has already applied for the specific job
            header("Location: index.php?error=You have already applied for this job");
            exit();
        } else if ($result3->num_rows >= 1) {
            $_SESSION['error_message'] = "You can only apply one job at a time.";
            header("Location: index.php");
            exit();
        } else {
            $query = "INSERT INTO job_applicants (user_id, job_id, application_status) VALUES (?, ?, ?)";
            $status = "Pending";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iis", $userId, $jobId, $status);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION["success_message"] = "Application Submitted";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION["error_message"] = "Application Failed. Try Again";
                header("Location: index.php");
                exit();
            }
        }
    }
}

?>