<?php
session_start();
include ("dbconn.php");

//For Showing the Jobs
if (isset($_SESSION['user_id'])) {
    //Showing only the jobs that the currently logged in user has not applied
    $userId = $_SESSION['user_id'];
    $mrf_status = "Post";
    $query =
        "SELECT mrfs.* 
        FROM mrfs
        LEFT JOIN job_applicants ON mrfs.id = job_applicants.job_id AND job_applicants.user_id = ?
        WHERE mrfs.mrf_status = ? AND job_applicants.user_id IS NULL";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $userId, $mrf_status);
    $stmt->execute();
    $result = $stmt->get_result();

    //Getting the currently logged in user's resume to know if its empty
    $query2 = "SELECT * FROM user_resumes WHERE user_id=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $userId);
    $stmt2->execute();
    $result2 = $stmt2->get_result();



} else {
    //Showing all jobs for not logged in user
    $mrf_status = "Post";

    $query = "SELECT * FROM mrfs WHERE mrf_status = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $mrf_status);
    $stmt->execute();
    $result = $stmt->get_result();
}


if (isset($_GET['loc'])) {
    $location = $_GET['loc'];
    if (isset($_SESSION['user_id'])) {
        //Sorting location for logged in user
        $query = "SELECT mrfs.* 
        FROM mrfs
        LEFT JOIN job_applicants ON mrfs.id = job_applicants.job_id AND job_applicants.user_id = '$userId'
        WHERE  mrfs.mrf_status = 'Post' AND job_applicants.user_id IS NULL AND mrfs.location LIKE '%$location%'";
        $result = mysqli_query($conn, $query);
    } else {
        //Sorting location for not logged in user
        $query =
            "SELECT * FROM mrfs 
            WHERE mrfs.location LIKE '%$location%'";
        $result = mysqli_query($conn, $query);
    }
}

if (isset($_GET['type'])) {
    $jobType = $_GET['type'];
    if (isset($_SESSION['user_id'])) {

        //Sorting location for logged in user
        $query = "SELECT mrfs.* 
        FROM mrfs
        LEFT JOIN job_applicants ON mrfs.id = job_applicants.job_id AND job_applicants.user_id = '$userId'
        WHERE mrfs.mrf_status = 'Post' AND job_applicants.user_id IS NULL AND mrfs.contract_type LIKE '%$jobType%'";
        $result = mysqli_query($conn, $query);
    } else {
        //Sorting location for not logged in user
        $query =
            "SELECT * FROM mrfs 
            WHERE mrfs.job_type LIKE '%$jobType%'";
        $result = mysqli_query($conn, $query);
    }
}

if (isset($_GET['industry'])) {
    $industry = $_GET['industry'];
    if (isset($_SESSION['user_id'])) {

        //Sorting location for logged in user
        $query = "SELECT mrfs.* 
        FROM mrfs
        LEFT JOIN job_applicants ON mrfs.id = job_applicants.job_id AND job_applicants.user_id = '$userId'
        WHERE mrfs.mrf_status = 'Post' AND job_applicants.user_id IS NULL AND mrfs.industry LIKE '%$industry%'";
        $result = mysqli_query($conn, $query);
    } else {
        //Sorting location for not logged in user
        $query =
            "SELECT * FROM mrfs 
            WHERE mrfs.job_type LIKE '%$industry%'";
        $result = mysqli_query($conn, $query);
    }
}


?>