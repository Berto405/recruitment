<?php
session_start();
include ("dbconn.php");

define("STATUS_HOLD", "Hold");
define("STATUS_CANCEL", "Cancel");
define("STATUS_CLOSE", "Close");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['mrf_id'])) {


    if (isset($_POST['postBtn'])) {
        postJob($conn);
    } else if (isset($_POST['holdBtn'])) {
        udpateMrfStatus($conn, STATUS_HOLD);
    } else if (isset($_POST['cancelBtn'])) {
        udpateMrfStatus($conn, STATUS_CANCEL);
    } else if (isset($_POST['closeBtn'])) {
        udpateMrfStatus($conn, STATUS_CLOSE);
    }
}


//FUNCTIONS HERE

function udpateMrfStatus($conn, $status)
{
    $mrfId = $_POST['mrf_id'];

    if ($status == "Close") {
        $currentDate = date("Y-m-d");

        $query = "UPDATE mrfs SET mrf_status = ?, closed_date = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $status, $currentDate, $mrfId);
    } else {
        $query = "UPDATE mrfs SET mrf_status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $mrfId);
    }
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION["success_message"] = "MRF Status Updated";
    } else {
        $_SESSION["error_message"] = "MRF Status Update Failed. Try Again";
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

function postJob($conn)
{
    $mrfId = $_POST['mrf_id'];

    $industry = $_POST["industry"];
    $mrfStatus = "Post";
    $loc = $_POST["location"];
    $newRequest = $_POST['newRequest'];
    $classification = $_POST['classification'];
    $client = $_POST['client'];
    $jobPosition = $_POST["jobPosition"];
    $numberRequired = $_POST['numberRequired'];
    $contractType = $_POST["contractType"];
    $jobDesc = $_POST["jobDescription"];
    $qualification = $_POST["qualification"];

    $query = "UPDATE mrfs SET industry=?, mrf_status=?, client=?, location=?, new_request=?, head_count=?, job_position=?, contract_type=?, classification=?, job_description=?, qualification=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssisssssi", $industry, $mrfStatus, $client, $loc, $newRequest, $numberRequired, $jobPosition, $contractType, $classification, $jobDesc, $qualification, $mrfId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION["success_message"] = "Job Posted";
    } else {
        $_SESSION["error_message"] = "Job Post Failed. Try Again";
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

?>