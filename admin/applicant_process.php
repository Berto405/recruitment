<?php
session_start();
include ('../dbconn.php');


// Define application status constants
define("STATUS_PASSED", "Passed");
define("STATUS_POOLING", "Pooling");
define("STATUS_WAITING_FEEDBACK", "Waiting for Feedback");
define("STATUS_HIRED", "Hired");
define("STATUS_INITIAL_INTERVIEW", "For Initial Interview");
define("STATUS_FINAL_INTERVIEW", "For Final Interview");
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
        schedule_interview($conn, STATUS_INITIAL_INTERVIEW);

    } else if (isset($_POST['final_interviewBtn'])) {
        // Handle final interview
        schedule_interview($conn, STATUS_FINAL_INTERVIEW);

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
    //For Checkboxes
    else if (isset($_POST['multiPassBtn'])) {
        updateMultiApplicants($conn, STATUS_PASSED);

    } else if (isset($_POST['multiFailBtn'])) {
        //Handle failed applicant

    } else if (isset($_POST['multiPoolBtn'])) {
        updateApplicantStatus($conn, STATUS_POOLING);

    } else if (isset($_POST['multi_initial_interviewBtn'])) {


    } else if (isset($_POST['multi_final_interviewBtn'])) {


    } else if (isset($_POST['multiFeedbackBtn'])) {
        updateMultiApplicants($conn, STATUS_WAITING_FEEDBACK);

    } else if (isset($_POST['multiHiredBtn'])) {
        updateMultiApplicants($conn, STATUS_HIRED);

    } else if (isset($_POST['multiOngoingBtn'])) {
        updateMultiApplicants($conn, STATUS_ONGOING_REQUIREMENTS);

    } else if (isset($_POST['multiOnbaordingBtn'])) {
        updateMultiApplicants($conn, STATUS_ONBOARDING);

    } else if (isset($_POST['multiStartDateBtn'])) {
        updateMultiApplicants($conn, STATUS_WAITING_START_DATE);

    } else if (isset($_POST['multiPlacedBtn'])) {
        updateMultiApplicants($conn, STATUS_PLACED);

    } else if (isset($_POST['assignJobBtn'])) {
        assignJob($conn);



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



//Function to update multiple rows 
function updateMultiApplicants($conn, $status)
{
    if (isset($_POST['checkbox_value'])) {

        foreach ($_POST['checkbox_value'] as $applicantId) {

            $query = "UPDATE job_applicants SET application_status = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $status, $applicantId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['success_message'] = "Applicants status updated successfully";
            } else {
                $_SESSION['error_message'] = "Failed to update applicant status";
            }
        }

        redirectBack();
    } else {
        $_SESSION['error_message'] = "Select at least 1 data.";
        redirectBack();
    }
}

//Function to assign job to a pooling applicant status
function assignJob($conn)
{
    if (isset($_POST["jobSelect"])) {
        $applicant_id = $_POST['applicant_id'];
        $job_id = $_POST['jobSelect'];
        $applicationStatus = "Pooled";

        $updateQuery = "UPDATE job_applicants SET job_id = ?, application_status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("isi", $job_id, $applicationStatus, $applicant_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = "Assigned MRF to applicant successfully";
        } else {
            $_SESSION['error_message'] = "Failed to assign MRF applicant";
        }
        redirectBack();
    } else {
        $_SESSION['error_message'] = "Select at least 1 from the list.";
        redirectBack();
    }
}


//Function to schedule initial interview
function schedule_interview($conn, $status)
{
    $applicantId = $_POST['applicant_id'];
    $interview_start = $_POST['interview_date'];
    $interview_end = date('Y-m-d H:i:s', strtotime('+1 Hour', strtotime($interview_start)));

    //Checking if there are already an existing schedule with its 1 hour duration
    $query = "SELECT * FROM job_applicants 
          WHERE (? BETWEEN interview_date AND DATE_ADD(interview_date, INTERVAL 1 HOUR)) 
             OR (? BETWEEN interview_date AND DATE_ADD(interview_date, INTERVAL 1 HOUR)) 
             OR (interview_date BETWEEN ? AND ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $interview_start, $interview_end, $interview_start, $interview_end);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error_message'] = "Sorry, there's already an interview scheduled within this time slot. Try another.";
        header("Location: ../admin/shortlisted_applicant.php");
        exit();
    } else {
        $query = "UPDATE job_applicants SET interview_date = ?, application_status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $interview_start, $status, $applicantId);
        $stmt->execute();
        $result = $stmt->get_result();

        $_SESSION['success_message'] = "Interview Scheduled";
        header("Location: ../admin/shortlisted_applicant.php");
        exit();
    }
}

// Function to redirect back
function redirectBack()
{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>