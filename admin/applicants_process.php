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

    if (isset ($_POST['application_id'])) {
        $application_id = $_POST['application_id'];
        // Assuming $conn is your database connection
        $query = "SELECT application_status FROM job_applicants WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $application_id);
        $stmt->execute();
        $stmt->bind_result($application_status);
        $stmt->fetch();
        $stmt->close();

        // Check if the application_status is not "Interview"
        if ($application_status !== "Interview") {
            // If application_status is not "Interview", then execute the function
            review_applicant($conn);
        }
    }
}


//FUNCTIONS HERE

function review_applicant($conn)
{
    $applicantId = $_POST['application_id'];

    $query = "UPDATE job_applicants SET application_status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $status = "Reviewed";
    $stmt->bind_param("si", $status, $applicantId);
    $stmt->execute();
    $result = $stmt->get_result();
}
function schedule_interview($conn)
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
        header("Location: ../admin/applicants.php");
        exit();
    } else {
        $query = "UPDATE job_applicants SET interview_date = ?, application_status = ? WHERE id = ?";
        $applicationStatus = "Interview";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $interview_start, $applicationStatus, $applicantId);
        $stmt->execute();
        $result = $stmt->get_result();

        $_SESSION['success_message'] = "Interview Scheduled";
        header("Location: ../admin/applicants.php");
        exit();
    }
}

function hire_applicant($conn)
{
    $applicantId = $_POST["hire_applicant"];

    $query = "UPDATE job_applicants SET application_status = ? WHERE id = ?";
    $applicationStatus = "Selected";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $applicationStatus, $applicantId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
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

    $query = "UPDATE job_applicants SET application_status = ? WHERE id = ?";
    $applicationStatus = "Not Selected";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $applicationStatus, $applicantId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Applicant Not Hired";
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again";
    }
    header("Location: ../admin/applicants.php");
    exit();
}

?>