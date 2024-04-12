<?php
session_start();
include ('../dbconn.php');

//For displaying number of registered users
$role = "admin";
$regQuery = "SELECT COUNT(id) AS countRegistered FROM user WHERE role = ?";
$stmtReg = $conn->prepare($regQuery);
$stmtReg->bind_param("s", $role);
$stmtReg->execute();
$resultReg = $stmtReg->get_result();
$rowReg = $resultReg->fetch_assoc();
$countReg = $rowReg['countRegistered'];

//For displaying number of applicants
$appQuery = "SELECT COUNT(id) AS countApplicant FROM job_applicants";
$stmtApp = $conn->prepare($appQuery);
$stmtApp->execute();
$resultApp = $stmtApp->get_result();
$rowApp = $resultApp->fetch_assoc();
$countApp = $rowApp['countApplicant'];


//For displaying of Today's Interviews
$today = date("Y-m-d");
$notSelectedStatus = "Not Selected";
$selectedStatus = "Selected";
$query =
    "SELECT job_applicants.*, mrfs.job_position, mrfs.location, user.first_name, user.last_name, user.resume
    FROM ((job_applicants
    INNER JOIN mrfs ON job_applicants.job_id = mrfs.id)
    INNER JOIN user ON job_applicants.user_id = user.id)
    WHERE job_applicants.application_status != ? AND job_applicants.application_status != ? AND DATE(job_applicants.interview_date) = ?
   ";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $notSelectedStatus, $selectedStatus, $today);
$stmt->execute();
$result = $stmt->get_result();

?>