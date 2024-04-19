<?php
session_start();
include ("../dbconn.php");

date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $industry = $_POST["industry"];
    $mrfStatus = "Hold";
    $loc = $_POST["location"];
    $newRequest = $_POST['newRequest'];
    $classification = $_POST['classification'];
    $client = $_POST['client'];
    $jobPosition = $_POST["jobPosition"];
    $numberRequired = $_POST['numberRequired'];
    $contractType = $_POST["contractType"];
    $jobDesc = $_POST["jobDescription"];
    $qualification = $_POST["qualification"];

    $conn->begin_transaction();

    $query =
        "INSERT INTO mrfs (industry, mrf_status, client, location, new_request, head_count, job_position, contract_type, classification, job_description, qualification)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssisssss", $industry, $mrfStatus, $client, $loc, $newRequest, $numberRequired, $jobPosition, $contractType, $classification, $jobDesc, $qualification);
    $stmt->execute();

    // Get the primary key of the new record
    $id = $conn->insert_id;

    if (!empty($id)) {
        // Determine MRF number based on industry
        if ($industry == 'Retail') {
            $mrfNumber = 're_' . $id;
        } else if ($industry == 'Logistics') {
            $mrfNumber = 'log_' . $id;
        } else if ($industry == 'Maintenance') {
            $mrfNumber = 'main_' . $id;
        } else if ($industry == 'Food Services') {
            $mrfNumber = 'food_' . $id;
        }

        // Prepare and execute UPDATE statement

        $stmt2 = $conn->prepare("UPDATE mrfs SET mrf_number = ? WHERE id = ?");
        $stmt2->bind_param("si", $mrfNumber, $id);
        if ($stmt2->execute()) {
            // Check if the UPDATE was successful
            if ($stmt2->affected_rows > 0) {

                $_SESSION["success_message"] = "MRF Submitted";
            } else {
                $_SESSION["error_message"] = "MRF Submission Failed. No rows were updated.";
            }
        } else {
            $_SESSION["error_message"] = "MRF Submission Failed. Error: " . $stmt2->error;
        }
    } else {
        $_SESSION["error_message"] = "Failed to retrieve ID of the new record";
    }


    // Commit the transaction
    $conn->commit();

    // Redirect to appropriate page
    header("Location: ../admin/add_mrf.php");
    exit();
}





?>