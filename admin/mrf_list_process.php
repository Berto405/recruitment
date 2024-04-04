<?php
session_start();
include ("../dbconn.php");

define("STATUS_HOLD", "Hold");
define("STATUS_CANCEL", "Cancel");
define("STATUS_CLOSE", "Close");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['mrf_id'])) {
    if (isset($_POST['holdBtn'])) {
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
        header("Location: ../admin/mrf_list.php");
        exit();
    } else {

        $_SESSION["error_message"] = "MRF Status Update Failed. Try Again";
        header("Location: ../admin/mrf_list.php");
        exit();
    }
}

?>