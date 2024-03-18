<?php
session_start();
include ("../dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $jobName = $_POST["jobName"];
    $salary = $_POST["salary"];
    $shift = $_POST["shift"];
    $loc = $_POST["location"];
    $priority = $_POST["priority"];
    $type = $_POST["jobType"];
    $dept = $_POST["department"];
    $jobDesc = $_POST["jobDescription"];
    $benefits = $_POST["benefits"];

    $query =
        "INSERT INTO jobs (job_name, salary, job_type, shift_and_schedule, location, job_description, benefits, priority, department) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisssssss", $jobName, $salary, $type, $shift, $loc, $jobDesc, $benefits, $priority, $dept);
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
} else {
    header("Location: ../admin/home.php");
    exit();
}
?>