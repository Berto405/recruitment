<?php
session_start();
include ("../dbconn.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {


    //Schedule Interview
    if (isset ($_POST['applicant_id'])) {
        schedule_interview($conn);
    }

    if (isset ($_POST['hire_applicant']) && isset ($_POST['applicant_user_id'])) {
        hire_applicant($conn);
    }

    if (isset ($_POST['reject_applicant']) && isset ($_POST['applicant_user_id'])) {
        reject_applicant($conn);
    }

}


//FUNCTIONS HERE

function schedule_interview($conn)
{
    $applicantId = $_POST['applicant_id'];
    $interview_start = $_POST['interview_date'];
    $interview_end = date('Y-m-d H:i:s', strtotime('+1 Hour', strtotime($interview_start)));

    //Checking if there are already an existing schedule with its 1 hour duration
    $query =
        "SELECT * FROM job_applicants 
        WHERE ('$interview_start' BETWEEN interview_date AND DATE_ADD(interview_date, INTERVAL 1 HOUR)) 
        OR ('$interview_end' BETWEEN interview_date AND DATE_ADD(interview_date, INTERVAL 1 HOUR))";
    $result = mysqli_query($conn, $query);


    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error_message'] = "Sorry, there's already an interview scheduled within this time slot. Try another.";
        header("Location: ../admin/applicants.php");
        exit();
    } else {
        $query = "UPDATE job_applicants SET interview_date ='$interview_start', application_status = 'Interview' WHERE id = '$applicantId'";
        $result = mysqli_query($conn, $query);
        $_SESSION['success_message'] = "Interview Scheduled";
        header("Location: ../admin/applicants.php");
        exit();
    }
}

function hire_applicant($conn)
{
    $applicantId = $_POST["hire_applicant"];

    $query = "UPDATE job_applicants SET application_status = 'Selected' WHERE id = '$applicantId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success_message'] = "Applicant Hired";
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again";
    }
    header("Location: ../admin/applicants.php");
    exit();

}

function reject_applicant($conn)
{
    $applicantId = $_POST["reject_applicant"];

    $query = "UPDATE job_applicants SET application_status = 'Not Selected' WHERE id = '$applicantId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success_message'] = "Applicant Not Hired";
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again";
    }
    header("Location: ../admin/applicants.php");
    exit();
}

?>