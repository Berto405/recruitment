<?php
session_start();
include ("../dbconn.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset ($_POST['editJobBtn'])) {
        editJob($conn);
    }

    if (isset ($_POST['delete_job_id'])) {
        deleteJob($conn);
    }
}


//FUNCTIONS HERE

function editJob($conn)
{
    $jobId = $_POST['jobId'];
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
        "UPDATE jobs 
    SET job_name = ?, salary = ?, job_type = ?, shift_and_schedule = ?, location = ?, job_description = ?, benefits = ?, priority = ?, department = ?
    WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisssssssi", $jobName, $salary, $type, $shift, $loc, $jobDesc, $benefits, $priority, $dept, $jobId);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
        $_SESSION["success_message"] = "Job Updated";
        header("Location: ../admin/jobs_list.php");
        exit();
    } else {

        $_SESSION["error_message"] = "Job Update Failed. Try Again";
        header("Location: ../admin/jobs_list.php");
        exit();
    }
}

function deleteJob($conn)
{
    $jobId = $_POST["delete_job_id"];


    $query = "DELETE FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $jobId);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Deleted Job Post.";
        header("Location: ../admin/jobs_list.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to Delete Job Post.";
        header("Location: ../admin/jobs_list.php");
        exit();
    }
}
?>