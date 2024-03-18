<?php
include ("dbconn.php");

//For Showing the Jobs
if (isset ($_SESSION['user_id'])) {
    //Showing only the jobs that the currently logged in user has not applied
    $userId = $_SESSION['user_id'];
    $query =
        "SELECT jobs.* 
        FROM jobs
        LEFT JOIN job_applicants ON jobs.id = job_applicants.job_id AND job_applicants.user_id = ?
        WHERE job_applicants.user_id is NULL
        ORDER BY 
            CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END,
            CASE WHEN jobs.priority = 'Non-urgent Hiring' THEN jobs.created_at END DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    //Getting the currently logged in user's resume to know if its empty
    $query2 = "SELECT resume FROM user WHERE id=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $userId);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $row = $result2->fetch_assoc();
    $resume = $row['resume'];
} else {
    //Showing all jobs for not logged in user
    $query = "SELECT * FROM jobs ORDER BY CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
}


if (isset ($_GET['loc'])) {
    $location = $_GET['loc'];
    if (isset ($_SESSION['user_id'])) {
        //Sorting location for logged in user
        $query = "SELECT jobs.* 
        FROM jobs
        LEFT JOIN job_applicants ON jobs.id = job_applicants.job_id AND job_applicants.user_id = '$userId'
        WHERE job_applicants.user_id IS NULL AND jobs.location LIKE '%$location%'
        ORDER BY 
            CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END,
            CASE WHEN jobs.priority = 'Non-urgent Hiring' THEN jobs.created_at END DESC";
        $result = mysqli_query($conn, $query);
    } else {
        //Sorting location for not logged in user
        $query =
            "SELECT * FROM jobs 
            WHERE jobs.location LIKE '%$location%'
            ORDER BY 
                CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
        $result = mysqli_query($conn, $query);
    }
}

if (isset ($_GET['type'])) {
    $jobType = $_GET['type'];
    if (isset ($_SESSION['user_id'])) {

        //Sorting location for logged in user
        $query = "SELECT jobs.* 
        FROM jobs
        LEFT JOIN job_applicants ON jobs.id = job_applicants.job_id AND job_applicants.user_id = '$userId'
        WHERE job_applicants.user_id IS NULL AND jobs.job_type LIKE '%$jobType%'
        ORDER BY 
            CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END,
            CASE WHEN jobs.priority = 'Non-urgent Hiring' THEN jobs.created_at END DESC";
        $result = mysqli_query($conn, $query);
    } else {
        //Sorting location for not logged in user
        $query =
            "SELECT * FROM jobs 
            WHERE jobs.job_type LIKE '%$jobType%'
            ORDER BY 
                CASE WHEN jobs.priority = 'Urgent Hiring' THEN 0 ELSE 1 END";
        $result = mysqli_query($conn, $query);
    }
}

?>