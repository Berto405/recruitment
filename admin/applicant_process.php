<?php
session_start();
include ('../dbconn.php');

date_default_timezone_set('Asia/Manila');

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
define("STATUS_BACK_TO_POOLING", "Back to Pooling");
define("STATUS_FAILED", "Failed");
define("STATUS_BACKOUT", "Backout");
define("STATUS_PLACED_WITH_ONGOING", "Placed with Ongoing Req.");
define("STATUS_PLACED_WITH_ONBOARDING", "Placed with Onboarding");

// Check if POST request is made
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['applicant_id'])) {
    if (isset($_POST['passBtn'])) {
        updateApplicantStatus($conn, STATUS_PASSED);

    } else if (isset($_POST['failBtn'])) {
        updateApplicantStatus($conn, STATUS_FAILED);

    } else if (isset($_POST['poolBtn'])) {
        updateApplicantStatus($conn, STATUS_POOLING);

    } else if (isset($_POST['backToPoolingBtn'])) {
        updateApplicantStatus($conn, STATUS_BACK_TO_POOLING);

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

    } else if (isset($_POST['placedWithOngoingBtn'])) {
        updateApplicantStatus($conn, STATUS_PLACED_WITH_ONGOING);

    } else if (isset($_POST['placedWithOnboardingBtn'])) {
        updateApplicantStatus($conn, STATUS_PLACED_WITH_ONBOARDING);

    } else if (isset($_POST['backoutBtn'])) {
        updateApplicantStatus($conn, STATUS_BACKOUT);

    }
    //For Checkboxes
    else if (isset($_POST['multiPassBtn'])) {
        updateMultiApplicants($conn, STATUS_PASSED);

    } else if (isset($_POST['multiFailBtn'])) {
        updateMultiApplicants($conn, STATUS_FAILED);

    } else if (isset($_POST['multiBackToPoolingBtn'])) {
        updateMultiApplicants($conn, STATUS_BACK_TO_POOLING);

    } else if (isset($_POST['multiPoolBtn'])) {
        updateMultiApplicants($conn, STATUS_POOLING);

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

    } else if (isset($_POST['multiPlacedWithOngoingBtn'])) {
        updateMultiApplicants($conn, STATUS_PLACED_WITH_ONGOING);

    } else if (isset($_POST['multiPlacedWithOnboardingBtn'])) {
        updateMultiApplicants($conn, STATUS_PLACED_WITH_ONBOARDING);

    } else if (isset($_POST['multiBackoutBtn'])) {
        updateMultiApplicants($conn, STATUS_BACKOUT);

    }

}
if (isset($_POST['assignJobBtn']) && isset($_POST['mrf_applicant_id'])) {
    assignJob($conn);
}


//FUNCTIONS HERE

// Function to update applicant status
function updateApplicantStatus($conn, $status)
{
    $applicantId = $_POST['applicant_id'];

    // Fetch existing remark and application status from the database
    $query = "SELECT remark, application_status FROM job_applicants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $applicantId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $existingRemark = $row['remark'];
    $applicationStatus = $row['application_status'];

    $newRemark = $_POST['remark'] . '. ' . " <br> Remark by: " . $_SESSION['user_name'];
    $newLog = $_SESSION['user_name'] . ' changed status to ' . $status;

    // Concatenate existing remark with new remark, separated by a comma
    if (!empty($existingRemark)) {
        $newRemark = $existingRemark . ', ' . $newRemark;
    }

    udpateQuery($conn, $newRemark, $newLog, $applicationStatus, $status, $applicantId);

    redirectBack();
}


// Function to update multiple rows
function updateMultiApplicants($conn, $status)
{
    if (isset($_POST['checkbox_value'])) {

        foreach ($_POST['checkbox_value'] as $applicantId) {

            // Fetch existing remark and application status from the database
            $query = "SELECT remark, application_status FROM job_applicants WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $applicantId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $existingRemark = $row['remark'];
            $applicationStatus = $row['application_status'];

            $newRemark = $_POST['remark'] . '. ' . " <br> Remark by: " . $_SESSION['user_name'];
            $newLog = $_SESSION['user_name'] . ' changed status to ' . ' ' . $status;

            // Concatenate existing remark with new remark, separated by a comma
            if (!empty($existingRemark)) {
                $newRemark = $existingRemark . ', ' . $newRemark;
            }

            udpateQuery($conn, $newRemark, $newLog, $applicationStatus, $status, $applicantId);

        }
    } else {
        $_SESSION['error_message'] = "Select at least 1 data.";
    }
    redirectBack();
}

//Function to assign job to a pooling applicant status
function assignJob($conn)
{
    if (isset($_POST["jobSelect"])) {
        $applicantId = $_POST['mrf_applicant_id'];
        $job_id = $_POST['jobSelect'];
        $applicationStatus = "Pooled";

        $updateQuery = "UPDATE job_applicants SET job_id = ?, application_status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("isi", $job_id, $applicationStatus, $applicantId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {

            // Get the job_position based on the job_id
            $jobPositionQuery = "SELECT job_position FROM mrfs WHERE id = ?";
            $stmtJob = $conn->prepare($jobPositionQuery);
            $stmtJob->bind_param("i", $job_id);
            $stmtJob->execute();
            $resultJob = $stmtJob->get_result();
            $jobPosition = $resultJob->fetch_assoc()['job_position'];

            // Update successful, insert log
            $newLog = $_SESSION['user_name'] . ' assigned MRF: ' . $jobPosition;
            $logQuery = "INSERT INTO applicant_logs (applicant_id, log) VALUES (?, ?)";
            $logStmt = $conn->prepare($logQuery);
            $logStmt->bind_param("is", $applicantId, $newLog);
            $logStmt->execute();

            if ($logStmt->affected_rows > 0) {
                $_SESSION['success_message'] = "Assigned MRF to applicant successfully";
            } else {
                $_SESSION['error_message'] = "Failed to insert log for the assignment";
            }
        } else {
            $_SESSION['error_message'] = "Failed to assign MRF to applicant: " . $stmt->error;
        }
    } else {
        $_SESSION['error_message'] = "Select at least 1 from the list.";
    }
    // Redirect back after processing
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}



function udpateQuery($conn, $newRemark, $newLog, $applicationStatus, $status, $applicantId)
{
    // Check if application status is Pooling. Returns an error if user did not select MRF before doing any action
    if ($applicationStatus == 'Pooling') {
        $_SESSION['error_message'] = "You can't proceed without selecting an MRF for this applicant.";
    } else {
        if (isset($_POST['failBtn']) || isset($_POST['backToPoolingBtn'])) {
            // Proceed with updating the applicant status with remark 
            $query = "UPDATE job_applicants SET application_status = ?, remark = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $status, $newRemark, $newLog, $applicantId);


        } else {
            // Proceed with updating the applicant status 
            $query = "UPDATE job_applicants SET application_status = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $status, $applicantId);

        }

        $stmt->execute();

        // Check if update was successful
        if ($stmt->affected_rows > 0) {
            //Insert a log
            $logQuery = "INSERT INTO applicant_logs (applicant_id, log) VALUES (?, ?)";
            $logStmt = $conn->prepare($logQuery);
            $logStmt->bind_param("is", $applicantId, $newLog);
            $logStmt->execute();

            $_SESSION['success_message'] = "Applicant status updated successfully";
        } else {
            $_SESSION['error_message'] = "Failed to update applicant status";
        }

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
        // Update successful, insert log
        $interview = new DateTime($_POST['interview_date']);
        $newLog = $_SESSION['user_name'] . ' scheduled an interview on ' . $interview->format('h:iA M d, Y');

        $logQuery = "INSERT INTO applicant_logs (applicant_id, log) VALUES (?, ?)";
        $logStmt = $conn->prepare($logQuery);
        $logStmt->bind_param("is", $applicantId, $newLog);
        $logStmt->execute();

        //Set an interview
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