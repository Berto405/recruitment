<?php
session_start();
include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['job_id'])) {
        $jobId = $_POST['job_id'];
        $userId = $_SESSION['user_id'];

        //Check if user has already applied for the specific job
        $checkQuery = "SELECT * FROM job_applicants WHERE user_id = '$userId' AND job_id = '$jobId'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            //User has already applied for the specific job
            header("Location: index.php?error=You have already applied for this job");
            exit();
        } else {
            $query = "INSERT INTO job_applicants (user_id, job_id, application_status) VALUES ('$userId', '$jobId', 'Pending')";
            $result = mysqli_query($conn, $query);

            if ($result) {

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