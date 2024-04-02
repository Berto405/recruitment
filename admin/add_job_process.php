<?php
session_start();
include ("../dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $jobName = $_POST["jobName"];
    $numRequired = $_POST["numRequired"];
    $shift = $_POST["shift"];
    $loc = $_POST["location"];
    $priority = $_POST["priority"];
    $type = $_POST["jobType"];
    $industry = $_POST["industry"];
    $jobDesc = $_POST["jobDescription"];
    $qualification = $_POST["qualification"];

    $query =
        "INSERT INTO jobs (job_name, number_required, job_type, shift_and_schedule, location, job_description, qualification, priority, industry) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisssssss", $jobName, $numRequired, $type, $shift, $loc, $jobDesc, $qualification, $priority, $industry);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION["success_message"] = "Job Posted";
        header("Location: ../admin/home.php");
        exit();
    } else {

        $_SESSION["error_message"] = "Job Post Failed. Try Again";
        header("Location: ../admin/home.php");
        exit();
    }
}
?>