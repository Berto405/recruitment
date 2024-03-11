<?php
session_start();
include("../dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    //Schedule Interview
    if (isset($_POST['applicant_id'])) {
        $applicantId = $_POST['applicant_id'];
        $date = $_POST['interview_date'];


        $query = "UPDATE job_applicants SET interview_date ='$date', application_status = 'Interview' WHERE id = '$applicantId'";
        $result = mysqli_query($conn, $query);

        header("Location: ../admin/applicants.php?message=Interview Scheduled");
        exit();
    }
}
?>