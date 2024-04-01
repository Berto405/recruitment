<?php
session_start();
include ('../dbconn.php');

// Define application status constants
define("STATUS_PASSED", "Passed");
define("STATUS_POOLING", "Pooling");
define("STATUS_WAITING_FEEDBACK", "Waiting for Feedback");
define("STATUS_HIRED", "Hired");
define("STATUS_ONGOING_REQUIREMENTS", "Ongoing Requirements");
define("STATUS_ONBOARDING", "Onboarding");
define("STATUS_WAITING_START_DATE", "Waiting for Start Date");
define("STATUS_PLACED", "Placed");

// Check if POST request is made
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['applicant_id'])) {
    if (isset($_POST['passBtn'])) {
        updateApplicantStatus($conn, STATUS_PASSED);
    } else if (isset($_POST['failBtn'])) {
        // Handle failed applicant


    } else if (isset($_POST['poolBtn'])) {
        updateApplicantStatus($conn, STATUS_POOLING);
    } else if (isset($_POST['initial_interviewBtn'])) {
        // Handle initial interview


    } else if (isset($_POST['final_interviewBtn'])) {
        // Handle final interview


    } else if (isset($_POST['feedbackBtn'])) {
        updateApplicantStatus($conn, STATUS_WAITING_FEEDBACK);
    } else if (isset($_POST['hiredBtn'])) {
        updateApplicantStatus($conn, STATUS_HIRED);
    } else if (isset($_POST['ongoingBtn'])) {
        updateApplicantStatus($conn, STATUS_ONGOING_REQUIREMENTS);
    } else if (isset($_POST['onbaordingBtn'])) {
        updateApplicantStatus($conn, STATUS_ONBOARDING);
    } else if (isset($_POST['startDateBtn'])) {
        updateApplicantStatus($conn, STATUS_WAITING_START_DATE);
    } else if (isset($_POST['placedBtn'])) {
        updateApplicantStatus($conn, STATUS_PLACED);
    }
}


//FUNCTIONS HERE

// Function to update applicant status
function updateApplicantStatus($conn, $status)
{
    $applicantId = $_POST['applicant_id'];
    $query = "UPDATE job_applicants SET application_status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $applicantId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Applicant status updated successfully";
    } else {
        $_SESSION['error_message'] = "Failed to update applicant status";
    }
    redirectBack();
}

// Function to redirect back
function redirectBack()
{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>