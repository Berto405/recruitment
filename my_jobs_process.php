<?php
session_start();
include ("dbconn.php");


if ($_SESSION['user_role'] !== 'user') {

    $_SESSION['error_message'] = "Sorry. You don't have the permission to access this page.";
    header("Location: index.php");
    exit();
} else {

    $userId = $_SESSION['user_id'];
    $query =
        "SELECT mrfs.id AS mrf_id,  mrfs.job_position, mrfs.contract_type, mrfs.location, mrfs.job_description, mrfs.qualification, job_applicants.id AS applicant_id, job_applicants.application_status 
        FROM mrfs 
        INNER JOIN job_applicants ON mrfs.id = job_applicants.job_id
        WHERE job_applicants.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    //Determine the text color of application status
    function getStatusClass($status)
    {
        switch ($status) {
            case 'Pending':
                return 'text-secondary';
            case 'Passed':
                return 'text-success';
            case 'Failed':
                return 'text-danger';
            default:
                return ' ';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['applicantId'])) {
        cancelApplication($conn);
    }
}


function cancelApplication($conn)
{
    $applicantId = $_POST['applicantId'];

    $query = "DELETE FROM job_applicants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $applicantId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "You have cancelled your application.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to cancel application. Try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>